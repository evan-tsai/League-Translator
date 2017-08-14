<?php

namespace common\service;

use Yii;
use common\models\Champions;
use common\models\ChampionSpells;
class ChampionApi extends BaseApiService
{
    protected $_champions = [];
    protected $_spellData = [];
    protected $_columnTitle = [];

    protected function _getModelIDs() {
        $model = Champions::find()->select('champion_id')->asArray()->all();
        $championID = array_flip(array_column($model, 'champion_id'));

        $this->_columnTitle[] = 'champion_id';

        return $championID;
    }

    protected function _createData($newData, $label)
    {
        $localeTitle = $label.'_title';
        $this->_columnTitle[] = $localeTitle;
        $this->_columnTitle[] = $label;

        foreach ($newData as $id => $data) {
            $this->_champions[$id]['champion_id'] = $id;
            $this->_champions[$id][$localeTitle] = $data['title'];
            $this->_champions[$id][$label] = $data['name'];
            $this->_spellData[$id]['champion_id'] = $id;
            $this->_spellData[$id] = array_merge($this->_spellData[$id], $this->_getChampionData($data, $label));
        }
    }

    protected function _insertTable()
    {
        if (count($this->_champions) > 0) {
            $connection = Yii::$app->db;
            $trans = $connection->beginTransaction();
            try {
                $connection->createCommand()
                    ->batchInsert(Champions::tableName(), $this->_columnTitle, $this->_champions)
                    ->execute();
                $connection->createCommand()
                    ->batchInsert(ChampionSpells::tableName(), array_keys(reset($this->_spellData)), $this->_spellData)
                    ->execute();
                $trans->commit();
            } catch (\Exception $e) {
                $trans->rollBack();
                throw $e;
            }
        }
    }

    protected function _getChampionData($championData, $language) {
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
        try {
            $path = '@frontend/web/img/champions';
            if (!file_exists(Yii::getAlias($path))) {
                mkdir(Yii::getAlias($path), 0777);
            }
            $championName = $championData['key'];
            $alias = $path.'/'.$championName;
            if (!file_exists(Yii::getAlias($alias))) {
                mkdir(Yii::getAlias($alias), 0777);
                $urlPath = 'http://ddragon.leagueoflegends.com/cdn/'.$this->version.'/img/';
                $iconName = $championData['image']['full'];
                file_put_contents(Yii::getAlias($alias.'/'.$iconName), file_get_contents($urlPath.'champion/'.rawurlencode($iconName)));
                file_put_contents(Yii::getAlias($alias.'/Q.png'), file_get_contents($urlPath.'spell/'.rawurlencode($championData['spells'][0]['image']['full'])));
                file_put_contents(Yii::getAlias($alias.'/W.png'), file_get_contents($urlPath.'spell/'.rawurlencode($championData['spells'][1]['image']['full'])));
                file_put_contents(Yii::getAlias($alias.'/E.png'), file_get_contents($urlPath.'spell/'.rawurlencode($championData['spells'][2]['image']['full'])));
                file_put_contents(Yii::getAlias($alias.'/R.png'), file_get_contents($urlPath.'spell/'.rawurlencode($championData['spells'][3]['image']['full'])));
                file_put_contents(Yii::getAlias($alias.'/passive.png'), file_get_contents($urlPath.'passive/'.rawurlencode($championData['passive']['image']['full'])));
            }
        } catch (\ErrorException $e) {
            throw $e;
        }
        return $spellData;
    }
}