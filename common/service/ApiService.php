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
use common\models\ItemSubtypeList;

class ApiService
{
    public static $apiKey = 'RGAPI-b2bc22fe-b01e-4fca-8e2b-8cb65d3afd44';

    public static function insertItem() {
        $test = ItemSubtypeList::find()->asArray()->all();
        $test = array_column($test, 'english', 'subtype_id');
        die(var_dump($test));
    }

    public static function insertChampion() {
        // find all champion IDs in database
        $model = Champions::find()->select('champion_id')->asArray()->all();
        $championID = array_flip(array_column($model, 'champion_id'));

        $newChampions = [];
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

        return $newChampions;
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