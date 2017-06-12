<?php

namespace common\service;

use Yii;
use common\models\Map;

class MapApi extends BaseApiService
{
    protected $maps = [];

    public function insert()
    {
        $model = Map::find()->select('map_id')->asArray()->all();
        $mapID = array_flip(array_column($model, 'map_id'));

        $this->getLocaleApi($mapID);

        $this->insertTable();
    }

    protected function createData($newData, $label)
    {
        foreach ($newData as $id => $data) {
            $this->maps[$id]['map_id'] = $id;
            $this->maps[$id][$label] = $data['mapName'];
        }
    }

    protected function insertTable()
    {
        if (count($this->maps) > 0) {
            try {
                Yii::$app->db->createCommand()
                    ->batchInsert(Map::tableName(), array_merge(['map_id'], Yii::$app->params['languages']), $this->maps)
                    ->execute();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}