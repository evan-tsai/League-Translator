<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_type".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $subtype_id
 */
class ItemType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'subtype_id'], 'required'],
            [['item_id', 'subtype_id'], 'integer'],
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
            'subtype_id' => 'Subtype ID',
        ];
    }

    /**
     * @inheritdoc
     * @return ItemTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemTypeQuery(get_called_class());
    }

    public function getItems()
    {
        return $this->hasOne(Items::className(), ['item_id' => 'item_id']);
    }

    public function getItemSubtypeList()
    {
        return $this->hasOne(ItemSubtypeList::className(), ['subtype_id' => 'subtype_id']);
    }
}