<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $english
 * @property string $taiwan
 * @property string $china
 * @property string $korea
 * @property string $japan
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id'], 'required'],
            [['item_id'], 'integer'],
            [['english', 'taiwan', 'china', 'korea', 'japan'], 'string', 'max' => 32],
            [['item_id'], 'unique'],
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
            'english' => 'English',
            'taiwan' => 'Taiwan',
            'china' => 'China',
            'korea' => 'Korea',
            'japan' => 'Japan',
        ];
    }

    /**
     * @inheritdoc
     * @return ItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemsQuery(get_called_class());
    }
}