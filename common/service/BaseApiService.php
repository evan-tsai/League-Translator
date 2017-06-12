<?php

namespace common\service;

use Yii;
use yii\base\Object;

abstract class BaseApiService extends Object
{
    public $url;
    public $version;

    protected function getLocaleApi($dataID) {
        foreach (Yii::$app->params['languages'] as $key => $label) {
            $apiUrl = $this->url.$key.'&api_key='.Yii::$app->params['apiKey'];
            $response = file_get_contents($apiUrl);
            $localeData = json_decode($response, true);

            $newData = array_diff_key($localeData['data'], $dataID);
            if (count($newData) === 0) {
                break;
            }
            $this->createData($newData, $label);
        }
    }

    abstract public function insert();
    abstract protected function createData($newData, $label);
    abstract protected function insertTable();
}