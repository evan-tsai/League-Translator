<?php

namespace console\controllers;

use Yii;
use yii\web\Controller;
use common\models\Settings;
use common\service\ChampionApi;
use common\service\ItemApi;
use common\service\MapApi;
use common\helpers\SettingHelper;


class CronController extends Controller
{
    public function beforeAction($action)
    {
        /*if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
            \Yii::$app->response->content = 'Access Denied!';

            return FALSE;
        }*/

        if($action->id == 'update'){
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionUpdate() {
        $currentVersion = SettingHelper::getSetting('api.version');

        $versionUrl = 'https://na1.api.riotgames.com/lol/static-data/v3/realms?api_key='.Yii::$app->params['apiKey'];
        $response = file_get_contents($versionUrl);
        $versionData = json_decode($response, true);
        $version = $versionData['v'];

        if ($currentVersion !== $version) {
            try {
                $model = Settings::find()->byKey('api.version')->one();
                $model->property_val = $version;
                $model->save();

                $champions = new ChampionApi([
                    'url' => 'https://na1.api.riotgames.com/lol/static-data/v3/champions?champListData=spells&tags=image&tags=passive&dataById=true&locale=',
                    'version' => $version,
                ]);
                $champions->insert();

                $items = new ItemApi([
                    'url' => 'https://na1.api.riotgames.com/lol/static-data/v3/items?itemListData=image&tags=tags&tags=maps&locale=',
                    'version' => $version,
                ]);
                $items->insert();

                $maps = new MapApi([
                    'url' => 'https://na1.api.riotgames.com/lol/static-data/v3/maps?locale=',
                ]);
                $maps->insert();
            } catch (\Exception $e) {
                $body = $e->getMessage();
            }

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