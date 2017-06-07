<?php
/**
 * Created by PhpStorm.
 * User: Evan
 * Date: 6/2/2017
 * Time: 4:16 PM
 */

namespace common\service;

use Yii;
use common\models\Champions;
use common\models\ChampionSpells;
use common\models\Items;
use common\models\ItemType;
use common\models\ItemSubtypeList;
use common\models\Map;
use common\models\ItemMap;

class ApiService
{
    protected static $apiKey = 'RGAPI-b2bc22fe-b01e-4fca-8e2b-8cb65d3afd44';

    public static function insertItem() {
        $model = Items::find()->select('item_id')->asArray()->all();
        $itemID = array_flip(array_column($model, 'item_id'));

        $itemData = [];
        $typeData = [];
        $mapData = [];
        $itemList = self::getItemList();
        foreach (Yii::$app->params['languages'] as $key => $label) {
            $url = 'https://na1.api.riotgames.com/lol/static-data/v3/items?itemListData=image&tags=tags&tags=maps&locale='.$key.'&api_key='.self::$apiKey;
            $response = file_get_contents($url);
            $localeData = json_decode($response, true);

            $newItems = array_diff_key($localeData['data'], $itemID);
            if (count($newItems) === 0) {
                break;
            }

            foreach ($newItems as $id => $data) {
                if (!isset($data['name'])) {
                    continue;
                }
                $itemData[$id]['item_id'] = $id;
                $itemData[$id][$label] = $data['name'];

                if (isset($data['tags'])) {
                    foreach ($data['tags'] as $type) {
                        $type = strtoupper($type);
                        if (array_key_exists($type, $itemList)) {
                            $typeData[$id.'_'.$type]['item_id'] = $id;
                            $typeData[$id.'_'.$type]['subtype_id'] = $itemList[$type];
                        }
                    }
                }

                if (isset($data['maps'])) {
                    foreach ($data['maps'] as $mapID => $mapFlag) {
                        if (true === $mapFlag) {
                            $mapData[$id.'_'.$mapID]['item_id'] = $id;
                            $mapData[$id.'_'.$mapID]['map_id'] = $mapID;
                        }
                    }
                }

                // get item images
                $alias = '@frontend/web/img/item';
                $iconName = $data['image']['full'];
                $version = $localeData['version'];
                if (!file_exists(Yii::getAlias($alias))) {
                    mkdir(Yii::getAlias($alias), 0777);
                }

                if (!file_exists(Yii::getAlias($alias.'/'.$id.'.png'))) {
                    $urlPath = 'http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/';
                    file_put_contents(Yii::getAlias($alias.'/'.$id.'.png'), file_get_contents($urlPath.'item/'.rawurlencode($iconName)));
                }
            }
        }

        if ((count($itemData) + count($typeData) + count($mapData)) > 0) {
            $connection = Yii::$app->db;
            $trans = $connection->beginTransaction();

            try {
                $connection->createCommand()
                    ->batchInsert(Items::tableName(), array_merge(['item_id'], Yii::$app->params['languages']), $itemData)
                    ->execute();

                $connection->createCommand()
                    ->batchInsert(ItemType::tableName(), ['item_id', 'subtype_id'], $typeData)
                    ->execute();

                $connection->createCommand()
                    ->batchInsert(ItemMap::tableName(), ['item_id', 'map_id'], $mapData)
                    ->execute();

                $trans->commit();
            } catch (\Exception $e) {
                $trans->rollBack();
                throw $e;
            }
        }

    }

    protected static function insertChampion() {
        // find all champion IDs in database
        $model = Champions::find()->select('champion_id')->asArray()->all();
        $championID = array_flip(array_column($model, 'champion_id'));

        $champions = [];
        $spellData = [];
        $columnTitle[] = 'champion_id';
        foreach (Yii::$app->params['languages'] as $key => $label) {
            // call API while iterating through all regions
            $url = 'https://na1.api.riotgames.com/lol/static-data/v3/champions?champListData=spells&tags=image&tags=passive&dataById=true&locale='.$key.'&api_key='.self::$apiKey;
            $response = file_get_contents($url);
            $localeData = json_decode($response, true);

            // compare keys from Database & API
            $newChampions = array_diff_key($localeData['data'], $championID);
            if (count($newChampions) === 0) {
                break;
            }

            $localeTitle = $label.'_title';
            $columnTitle[] = $localeTitle;
            $columnTitle[] = $label;
            $version = $localeData['version'];

            foreach ($newChampions as $id => $data) {
                $champions[$id]['champion_id'] = $id;
                $champions[$id][$localeTitle] = $data['title'];
                $champions[$id][$label] = $data['name'];

                $spellData[$id]['champion_id'] = $id;
                $spellData[$id] = array_merge($spellData[$id], self::getChampionData($data, $label, $version));
            }
        }

        if (count($champions) > 0) {
            $connection = Yii::$app->db;
            $trans = $connection->beginTransaction();

            try {
                $connection->createCommand()
                    ->batchInsert(Champions::tableName(), $columnTitle, $champions)
                    ->execute();

                $connection->createCommand()
                    ->batchInsert(ChampionSpells::tableName(), array_keys(reset($spellData)), $spellData)
                    ->execute();

                $trans->commit();
            } catch (\Exception $e) {
                $trans->rollBack();
                throw $e;
            }
        }
    }

    // returns list with type as key, id as value
    protected static function getItemList() {
        $itemList = ItemSubtypeList::find()->asArray()->all();
        foreach ($itemList as &$value) {
            $string = str_replace(' ', '', $value['english']);
            $value['english'] = strtoupper($string);
        }
        $itemList = array_column($itemList, 'subtype_id', 'english');
        return $itemList;
    }

    public static function insertMap() {
        $model = Map::find()->select('map_id')->asArray()->all();
        $mapID = array_flip(array_column($model, 'item_id'));

        $maps = [];
        foreach (Yii::$app->params['languages'] as $key => $label) {
            $url = 'https://na1.api.riotgames.com/lol/static-data/v3/maps?locale=' . $key . '&api_key=' . self::$apiKey;
            $response = file_get_contents($url);
            $localeData = json_decode($response, true);

            $newMaps = array_diff_key($localeData['data'], $mapID);
            if (count($newMaps) === 0) {
                break;
            }
            foreach ($newMaps as $id => $data) {
                $maps[$id]['map_id'] = $id;
                $maps[$id][$label] = $data['mapName'];
            }
        }
        if (count($maps) > 0) {
            Yii::$app->db->createCommand()
                ->batchInsert(Map::tableName(), array_merge(['map_id'], Yii::$app->params['languages']), $maps)
                ->execute();
        }
    }

    protected static function getChampionData($championData, $language, $version) {
        $localePassive = $language.'_passive';
        $localeQ = $language.'_q';
        $localeW = $language.'_w';
        $localeE = $language.'_e';
        $localeR = $language.'_r';

        $spellData[$localePassive] = $championData['passive']['name'];
        $spellData[$localeQ] = $championData['spells'][0]['name'];
        $spellData[$localeW] = $championData['spells'][1]['name'];
        $spellData[$localeE] = $championData['spells'][2]['name'];
        $spellData[$localeR] = $championData['spells'][3]['name'];

        $championName = $championData['key'];

        $alias = '@frontend/web/img/'.$championName;
        if (!file_exists(Yii::getAlias($alias))) {
            mkdir(Yii::getAlias($alias), 0777);

            $urlPath = 'http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/';
            $iconName = $championData['image']['full'];

            file_put_contents(Yii::getAlias($alias.'/'.$iconName), file_get_contents($urlPath.'champion/'.rawurlencode($iconName)));
            file_put_contents(Yii::getAlias($alias.'/Q.png'), file_get_contents($urlPath.'spell/'.rawurlencode($championData['spells'][0]['image']['full'])));
            file_put_contents(Yii::getAlias($alias.'/W.png'), file_get_contents($urlPath.'spell/'.rawurlencode($championData['spells'][1]['image']['full'])));
            file_put_contents(Yii::getAlias($alias.'/E.png'), file_get_contents($urlPath.'spell/'.rawurlencode($championData['spells'][2]['image']['full'])));
            file_put_contents(Yii::getAlias($alias.'/R.png'), file_get_contents($urlPath.'spell/'.rawurlencode($championData['spells'][3]['image']['full'])));
            file_put_contents(Yii::getAlias($alias.'/passive.png'), file_get_contents($urlPath.'passive/'.rawurlencode($championData['passive']['image']['full'])));
        }

        return $spellData;
    }
}