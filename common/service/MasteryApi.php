<?php
/**
 * Created by PhpStorm.
 * User: Evan
 * Date: 6/20/2017
 * Time: 11:32 PM
 */

namespace common\service;

use Yii;
use common\models\Masteries;
use common\models\MasteryType;

class MasteryApi extends BaseApiService
{
    protected $_masteries;
    protected $_typeList = [];
    public function insert()
    {
        $model = Masteries::find()->select('mastery_id')->asArray()->all();
        $masteryID = array_flip(array_column($model, 'mastery_id'));

        $typeData = MasteryType::find()->asArray()->all();
        $this->_typeList = array_column($typeData, 'type_id', 'english');
        $this->_getLocaleApi($masteryID);

        $this->_insertTable();
    }

    protected function _createData($newData, $label)
    {
        foreach ($newData as $id => $data) {
            if ($label === 'english') {
                $this->_masteries[$id]['mastery_id'] = $id;
                if (array_key_exists($data['masteryTree'], $this->_typeList)) {
                    $this->_masteries[$id]['type'] = $this->_typeList[$data['masteryTree']];
                }
            }
            $this->_masteries[$id][$label] = $data['name'];

            try {
                $alias = '@frontend/web/img/masteries';
                $iconName = $data['image']['full'];
                if (!file_exists(Yii::getAlias($alias))) {
                    mkdir(Yii::getAlias($alias), 0777);
                }
                if (!file_exists(Yii::getAlias($alias.'/'.$id.'.png'))) {
                    $urlPath = 'http://ddragon.leagueoflegends.com/cdn/'.$this->version.'/img/';
                    file_put_contents(Yii::getAlias($alias.'/'.$id.'.png'), file_get_contents($urlPath.'mastery/'.rawurlencode($iconName)));
                }
            } catch (\ErrorException $e) {
                throw $e;
            }
        }
    }

    protected function _insertTable()
    {
        if (count($this->_masteries) > 0) {
            try {
                Yii::$app->db->createCommand()
                    ->batchInsert(Masteries::tableName(), array_merge(['mastery_id', 'type'], Yii::$app->params['languages']), $this->_masteries)
                    ->execute();
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }

}