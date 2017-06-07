<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_type_list".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $english
 * @property string $taiwan
 * @property string $china
 * @property string $korea
 * @property string $japan
 */
class ItemTypeList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_type_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'required'],
            [['type_id'], 'integer'],
            [['english', 'taiwan', 'china', 'korea', 'japan'], 'string', 'max' => 32],
            [['type_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Type ID',
            'english' => 'English',
            'taiwan' => 'Taiwan',
            'china' => 'China',
            'korea' => 'Korea',
            'japan' => 'Japan',
        ];
    }

    /**
     * @inheritdoc
     * @return ItemTypeListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemTypeListQuery(get_called_class());
    }
}