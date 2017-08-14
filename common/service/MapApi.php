<?php

namespace common\service;

use Yii;
use common\models\Map;

class MapApi extends BaseApiService
{
    protected $_maps = [];

    protected function _getModelIDs() {
        $model = Map::find()->select('map_id')->asArray()->all();
        $mapID = array_flip(array_column($model, 'map_id'));

        return $mapID;
    }

    protected function _createData($newData, $label)
    {
        foreach ($newData as $id => $data) {
            $this->_maps[$id]['map_id'] = $id;
            $this->_maps[$id][$label] = $data['mapName'];
        }
    }

    protected function _insertTable()
    {
        if (count($this->_maps) > 0) {
            try {
                Yii::$app->db->createCommand()
                    ->batchInsert(Map::tableName(), array_merge(['map_id'], Yii::$app->params['languages']), $this->_maps)
                    ->execute();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}