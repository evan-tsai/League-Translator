<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "map".
 *
 * @property integer $id
 * @property integer $map_id
 * @property string $english
 * @property string $taiwan
 * @property string $china
 * @property string $korea
 * @property string $japan
 */
class Map extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_id'], 'required'],
            [['map_id'], 'integer'],
            [['english', 'taiwan', 'china', 'korea', 'japan'], 'string', 'max' => 32],
            [['map_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'map_id' => 'Map ID',
            'english' => 'English',
            'taiwan' => 'Taiwan',
            'china' => 'China',
            'korea' => 'Korea',
            'japan' => 'Japan',
        ];
    }

    /**
     * @inheritdoc
     * @return MapQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapQuery(get_called_class());
    }
}