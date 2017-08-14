<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_map".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $map_id
 */
class ItemMap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'map_id'], 'required'],
            [['item_id', 'map_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'map_id' => 'Map ID',
        ];
    }

    /**
     * @inheritdoc
     * @return ItemMapQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemMapQuery(get_called_class());
    }

    public function getMap()
    {
        return $this->hasOne(Map::className(), ['map_id' => 'map_id']);
    }
}