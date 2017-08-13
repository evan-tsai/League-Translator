<?php
/**
 * Created by PhpStorm.
 * User: Evan
 * Date: 6/12/2017
 * Time: 11:35 PM
 */

namespace common\service;

use Yii;
use common\models\Map;
use common\models\SummonerSpells;

class SummonerSpellApi extends BaseApiService
{
    protected $_spells = [];

    public function insert()
    {
        $model = SummonerSpells::find()->select('spell_id')->asArray()->all();
        $spellID = array_flip(array_column($model, 'spell_id'));

        $this->_getLocaleApi($spellID);

        $this->_insertTable();
    }

    protected function _createData($newData, $label)
    {
        foreach ($newData as $id => $data) {
            if (in_array(Map::MAP_SUMMONERS_RIFT, $data['modes'])) {
                $this->_spells[$id]['spell_id'] = $id;
                $this->_spells[$id][$label] = $data['name'];

                // get summoner spell images
                $alias = '@frontend/web/img/summoner_spells';
                $iconName = $data['image']['full'];
                if (!file_exists(Yii::getAlias($alias))) {
                    mkdir(Yii::getAlias($alias), 0777);
                }

                if (!file_exists(Yii::getAlias($alias.'/'.$id.'.png'))) {
                    $urlPath = 'http://ddragon.leagueoflegends.com/cdn/'.$this->version.'/img/';
                    file_put_contents(Yii::getAlias($alias.'/'.$id.'.png'), file_get_contents($urlPath.'spell/'.rawurlencode($iconName)));
                }
            }
        }
    }

    protected function _insertTable()
    {
        if (count($this->_spells) > 0) {
            try {
                Yii::$app->db->createCommand()
                    ->batchInsert(SummonerSpells::tableName(), array_merge(['spell_id'], Yii::$app->params['languages']), $this->_spells)
                    ->execute();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}