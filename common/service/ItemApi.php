<?php

namespace common\service;

use Yii;
use common\models\Items;
use common\models\ItemSubtypeList;
use common\models\ItemType;
use common\models\ItemMap;

class ItemApi extends BaseApiService
{
    protected $itemData = [];
    protected $typeData = [];
    protected $mapData = [];
    protected $itemList = [];

    public function insert()
    {
        $model = Items::find()->select('item_id')->asArray()->all();
        $itemID = array_flip(array_column($model, 'item_id'));

        $this->itemList = $this->getItemList();
        $this->getLocaleApi($itemID);

        $this->insertTable();
    }

    protected function createData($newData, $label)
    {
        foreach ($newData as $id => $data) {
            if (!isset($data['name'])) {
                continue;
            }
            $this->itemData[$id]['item_id'] = $id;
            $this->itemData[$id][$label] = $data['name'];
            if (isset($data['tags']) && $label === 'english') {
                foreach ($data['tags'] as $type) {
                    $type = strtoupper($type);
                    if (array_key_exists($type, $this->itemList)) {
                        $this->typeData[$id.'_'.$type]['item_id'] = $id;
                        $this->typeData[$id.'_'.$type]['subtype_id'] = $this->itemList[$type];
                    }
                }
            }
            if (isset($data['maps']) && $label === 'english') {
                foreach ($data['maps'] as $mapID => $mapFlag) {
                    if (true === $mapFlag) {
                        $this->mapData[$id.'_'.$mapID]['item_id'] = $id;
                        $this->mapData[$id.'_'.$mapID]['map_id'] = $mapID;
                    }
                }
            }
            // get item images
            try {
                $alias = '@frontend/web/img/item';
                $iconName = $data['image']['full'];
                if (!file_exists(Yii::getAlias($alias))) {
                    mkdir(Yii::getAlias($alias), 0777);
                }
                if (!file_exists(Yii::getAlias($alias.'/'.$id.'.png'))) {
                    $urlPath = 'http://ddragon.leagueoflegends.com/cdn/'.$this->version.'/img/';
                    file_put_contents(Yii::getAlias($alias.'/'.$id.'.png'), file_get_contents($urlPath.'item/'.rawurlencode($iconName)));
                }
            } catch (\ErrorException $e) {
                throw $e;
            }
        }
    }

    protected function insertTable()
    {
        if ((count($this->itemData) + count($this->typeData) + count($this->mapData)) > 0) {
            $connection = Yii::$app->db;
            $trans = $connection->beginTransaction();
            try {
                $connection->createCommand()
                    ->batchInsert(Items::tableName(), array_merge(['item_id'], Yii::$app->params['languages']), $this->itemData)
                    ->execute();
                $connection->createCommand()
                    ->batchInsert(ItemType::tableName(), ['item_id', 'subtype_id'], $this->typeData)
                    ->execute();
                $connection->createCommand()
                    ->batchInsert(ItemMap::tableName(), ['item_id', 'map_id'], $this->mapData)
                    ->execute();
                $trans->commit();
            } catch (\Exception $e) {
                $trans->rollBack();
                throw $e;
            }
        }
    }

    protected function getItemList() {
        $itemList = ItemSubtypeList::find()->asArray()->all();
        foreach ($itemList as &$value) {
            $string = str_replace(' ', '', $value['english']);
            $value['english'] = strtoupper($string);
        }
        $itemList = array_column($itemList, 'subtype_id', 'english');
        return $itemList;
    }
}