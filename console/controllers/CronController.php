<?php

namespace console\controllers;

use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use common\models\Settings;
use common\helpers\SettingHelper;
use common\helpers\MailHelper;

class CronController extends Controller
{
    public function beforeAction($action)
    {
        if($action->id == 'update' || $action->id == 'init'){
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    // add cron job in linux, execute update every 24 hours
    public function actionInit() {
        $output = shell_exec('crontab -r');
        file_put_contents('/tmp/crontab.txt', $output.'30 2 * * * /usr/bin/php '.getcwd().'/yii cron/update'.PHP_EOL);
        echo exec('crontab /tmp/crontab.txt');
        $alias = '@frontend/web/img';
        if (!file_exists(Yii::getAlias($alias))) {
            mkdir(Yii::getAlias($alias), 0777);
        }
    }

    public function actionUpdate() {
        $currentVersion = SettingHelper::getSetting('api.version');

        $staticUrl = 'https://na1.api.riotgames.com/lol/static-data/v3/';
        $versionUrl = $staticUrl.'realms?api_key='.Yii::$app->params['apiKey'];
        $response = file_get_contents($versionUrl);
        $versionData = json_decode($response, true);
        $version = $versionData['v'];

        // check if api version has changed
        if ($currentVersion !== $version) {
            $connection = Yii::$app->db;
            $trans = $connection->beginTransaction();
            try {
                // save api version
                $model = Settings::find()->byKey('api.version')->one();
                $model->property_val = $version;
                $model->save();

                // maps has to be before item because item relies on current map data
                $classData = [
                    'ChampionApi' => $staticUrl.'champions?champListData=spells&tags=image&tags=passive&dataById=true&locale=',
                    'MapApi' => $staticUrl.'maps?locale=',
                    'ItemApi' => $staticUrl.'items?itemListData=image&tags=tags&tags=maps&locale=',
                    'MasteryApi' => $staticUrl.'masteries?tags=masteryTree&tags=image&locale=',
                    'SummonerSpellApi' => $staticUrl.'summoner-spells?dataById=true&tags=image&tags=modes&locale=',
                ];

                // update all data
                foreach ($classData as $className => $url) {
                    $fullClassName = '\common\service\\'.$className;
                    if (!class_exists($fullClassName)) {
                        throw new ErrorException($className.' does not exist.');
                    }
                    $apiClass = new $fullClassName([
                        'url' => $url,
                        'version' => $version,
                    ]);
                    $apiClass->updateData();
                }

                $trans->commit();
                $body = 'Update Successful!<br />Version Number: '.$version;
                MailHelper::writeMail($body, 'API Updated');
            } catch (\Exception $e) {
                $body = $e->getMessage();
                $trans->rollBack();
                MailHelper::writeMail($body, 'API Update Error');
            }
        }
    }
}