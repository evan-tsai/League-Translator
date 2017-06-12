<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "summoner_spells".
 *
 * @property integer $id
 * @property integer $spell_id
 * @property string $english
 * @property string $taiwan
 * @property string $china
 * @property string $korea
 * @property string $japan
 */
class SummonerSpells extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'summoner_spells';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spell_id', 'english'], 'required'],
            [['spell_id'], 'integer'],
            [['english', 'taiwan', 'china', 'korea', 'japan'], 'string', 'max' => 32],
            [['spell_id'], 'unique'],
            [['english'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'spell_id' => 'Spell ID',
            'english' => 'English',
            'taiwan' => 'Taiwan',
            'china' => 'China',
            'korea' => 'Korea',
            'japan' => 'Japan',
        ];
    }

    /**
     * @inheritdoc
     * @return SummonerSpellsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SummonerSpellsQuery(get_called_class());
    }
}