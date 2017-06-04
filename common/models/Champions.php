<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "champions".
 *
 * @property integer $id
 * @property integer $champion_id
 * @property string $name
 * @property string $taiwan
 * @property string $china
 * @property string $korea
 * @property string $japan
 * @property string $brazil
 */
class Champions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'champions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['champion_id', 'name'], 'required'],
            [['champion_id'], 'integer'],
            [['name', 'taiwan', 'china', 'korea', 'japan', 'brazil'], 'string', 'max' => 32],
            [['champion_id'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'champion_id' => 'Champion ID',
            'name' => 'Name',
            'taiwan' => 'Taiwan',
            'china' => 'China',
            'korea' => 'Korea',
            'japan' => 'Japan',
            'brazil' => 'Brazil',
        ];
    }

    /**
     * @inheritdoc
     * @return ChampionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChampionsQuery(get_called_class());
    }
}