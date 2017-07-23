<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "masteries".
 *
 * @property integer $id
 * @property integer $mastery_id
 * @property string $type
 * @property string $english
 * @property string $taiwan
 * @property string $china
 * @property string $korea
 * @property string $japan
 */
class Masteries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masteries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mastery_id', 'type'], 'required'],
            [['mastery_id'], 'integer'],
            [['type'], 'string', 'max' => 20],
            [['english', 'taiwan', 'china', 'korea', 'japan'], 'string', 'max' => 32],
            [['mastery_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mastery_id' => 'Mastery ID',
            'type' => 'Type',
            'english' => 'English',
            'taiwan' => 'Taiwan',
            'china' => 'China',
            'korea' => 'Korea',
            'japan' => 'Japan',
        ];
    }

    public function getMasteryType()
    {
        return $this->hasOne(MasteryType::className(), ['type_id' => 'type']);
    }

    /**
     * @inheritdoc
     * @return MasteriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MasteriesQuery(get_called_class());
    }
}