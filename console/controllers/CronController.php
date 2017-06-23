<?php

namespace console\controllers;

use Yii;
use yii\web\Controller;
use common\models\Settings;
use common\service\ChampionApi;
use common\service\ItemApi;
use common\service\MapApi;
use common\service\MasteryApi;
use common\service\SummonerSpellApi;
use common\helpers\SettingHelper;


class CronController extends Controller
{
    public function beforeAction($action)
    {
        // only executable on local
        /*if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
            \Yii::$app->response->content = 'Access Denied!';

            return false;
        }*/

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

        $versionUrl = 'https://na1.api.riotgames.com/lol/static-data/v3/realms?api_key='.Yii::$app->params['apiKey'];
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

                // update database
                $champions = new ChampionApi([
                    'url' => 'https://na1.api.riotgames.com/lol/static-data/v3/champions?champListData=spells&tags=image&tags=passive&dataById=true&locale=',
                    'version' => $version,
                ]);
                $champions->insert();

                $maps = new MapApi([
                    'url' => 'https://na1.api.riotgames.com/lol/static-data/v3/maps?locale=',
                ]);
                $maps->insert();

                $items = new ItemApi([
                    'url' => 'https://na1.api.riotgames.com/lol/static-data/v3/items?itemListData=image&tags=tags&tags=maps&locale=',
                    'version' => $version,
                ]);
                $items->insert();

                $items = new MasteryApi([
                    'url' => 'https://na1.api.riotgames.com/lol/static-data/v3/masteries?tags=masteryTree&tags=image&locale=',
                    'version' => $version,
                ]);
                $items->insert();

                $summonerSpells = new SummonerSpellApi([
                    'url' => 'https://na1.api.riotgames.com/lol/static-data/v3/summoner-spells?dataById=true&tags=image&tags=modes&locale=',
                    'version' => $version,
                ]);
                $summonerSpells->insert();
                $trans->commit();
            } catch (\Exception $e) {
                $body = $e->getMessage();
                $trans->rollBack();
            }

            // email admin on successful or failed update
            if (isset($body)) {
                $subject = 'API Update Error';
            } else {
                $subject = 'API Updated';
                $body = 'Update Successful!<br />Version Number: '.$version;
            }

            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['supportEmail'] => 'League Translate'])
                ->setTo(Yii::$app->params['adminEmail'])
                ->setSubject($subject)
                ->setHtmlBody($body)
                ->send();
        }
    }
}