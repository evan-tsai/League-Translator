<?php

namespace common\service;

use Yii;
use common\models\Champions;
use common\models\ChampionSpells;
class ChampionApi extends BaseApiService
{
    protected $champions = [];
    protected $spellData = [];
    protected $columnTitle = [];

    public function insert() {
        $model = Champions::find()->select('champion_id')->asArray()->all();
        $championID = array_flip(array_column($model, 'champion_id'));

        $this->columnTitle[] = 'champion_id';

        $this->getLocaleApi($championID);

        $this->insertTable();
    }

    protected function createData($newData, $label)
    {
        $localeTitle = $label.'_title';
        $this->columnTitle[] = $localeTitle;
        $this->columnTitle[] = $label;

        foreach ($newData as $id => $data) {
            $this->champions[$id]['champion_id'] = $id;
            $this->champions[$id][$localeTitle] = $data['title'];
            $this->champions[$id][$label] = $data['name'];
            $this->spellData[$id]['champion_id'] = $id;
            $this->spellData[$id] = array_merge($this->spellData[$id], $this->getChampionData($data, $label));
        }
    }

    protected function insertTable()
    {
        if (count($this->champions) > 0) {
            $connection = Yii::$app->db;
            $trans = $connection->beginTransaction();
            try {
                $connection->createCommand()
                    ->batchInsert(Champions::tableName(), $this->columnTitle, $this->champions)
                    ->execute();
                $connection->createCommand()
                    ->batchInsert(ChampionSpells::tableName(), array_keys(reset($this->spellData)), $this->spellData)
                    ->execute();
                $trans->commit();
            } catch (\Exception $e) {
                $trans->rollBack();
                throw $e;
            }
        }
    }

    protected function getChampionData($championData, $language) {
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
            $championName = $championData['key'];
            $alias = '@frontend/web/img/'.$championName;
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