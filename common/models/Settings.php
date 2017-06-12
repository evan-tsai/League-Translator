<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $property_name
 * @property string $property_key
 * @property string $property_val
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_name', 'property_key'], 'required'],
            [['property_name'], 'string', 'max' => 20],
            [['property_key'], 'string', 'max' => 40],
            [['property_val'], 'string', 'max' => 30],
            [['property_key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_name' => 'Property Name',
            'property_key' => 'Property Key',
            'property_val' => 'Property Val',
        ];
    }

    /**
     * @inheritdoc
     * @return SettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingsQuery(get_called_class());
    }
}