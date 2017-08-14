<?php

namespace common\service;

use Yii;
use yii\base\Object;

abstract class BaseApiService extends Object
{
    public $url;
    public $version;

    public function updateData() {
        $modelIDs = $this->_getModelIDs();

        foreach (Yii::$app->params['languages'] as $key => $label) {
            // url.com?locale=en_US&api_key
            $apiUrl = $this->url.$key.'&api_key='.Yii::$app->params['apiKey'];
            $response = file_get_contents($apiUrl);
            $localeData = json_decode($response, true);

            $newData = array_diff_key($localeData['data'], $modelIDs);
            if (count($newData) === 0) {
                break;
            }
            $this->_createData($newData, $label);
        }

        $this->_insertTable();
    }

    abstract protected function _getModelIDs();
    abstract protected function _createData($newData, $label);
    abstract protected function _insertTable();
}