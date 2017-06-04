<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "champion_spells".
 *
 * @property integer $id
 * @property integer $champion_id
 * @property string $english_passive
 * @property string $english_q
 * @property string $english_w
 * @property string $english_e
 * @property string $english_r
 * @property string $taiwan_passive
 * @property string $taiwan_q
 * @property string $taiwan_w
 * @property string $taiwan_e
 * @property string $taiwan_r
 * @property string $china_passive
 * @property string $china_q
 * @property string $china_w
 * @property string $china_e
 * @property string $china_r
 * @property string $korea_passive
 * @property string $korea_q
 * @property string $korea_w
 * @property string $korea_e
 * @property string $korea_r
 * @property string $japan_passive
 * @property string $japan_q
 * @property string $japan_w
 * @property string $japan_e
 * @property string $japan_r
 */
class ChampionSpells extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'champion_spells';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['champion_id'], 'required'],
            [['champion_id'], 'integer'],
            [['english_passive', 'english_q', 'english_w', 'english_e', 'english_r', 'taiwan_passive', 'taiwan_q', 'taiwan_w', 'taiwan_e', 'taiwan_r', 'china_passive', 'china_q', 'china_w', 'china_e', 'china_r', 'korea_passive', 'korea_q', 'korea_w', 'korea_e', 'korea_r', 'japan_passive', 'japan_q', 'japan_w', 'japan_e', 'japan_r'], 'string', 'max' => 32],
            [['champion_id'], 'unique'],
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
            'english_passive' => 'English Passive',
            'english_q' => 'English Q',
            'english_w' => 'English W',
            'english_e' => 'English E',
            'english_r' => 'English R',
            'taiwan_passive' => 'Taiwan Passive',
            'taiwan_q' => 'Taiwan Q',
            'taiwan_w' => 'Taiwan W',
            'taiwan_e' => 'Taiwan E',
            'taiwan_r' => 'Taiwan R',
            'china_passive' => 'China Passive',
            'china_q' => 'China Q',
            'china_w' => 'China W',
            'china_e' => 'China E',
            'china_r' => 'China R',
            'korea_passive' => 'Korea Passive',
            'korea_q' => 'Korea Q',
            'korea_w' => 'Korea W',
            'korea_e' => 'Korea E',
            'korea_r' => 'Korea R',
            'japan_passive' => 'Japan Passive',
            'japan_q' => 'Japan Q',
            'japan_w' => 'Japan W',
            'japan_e' => 'Japan E',
            'japan_r' => 'Japan R',
        ];
    }

    /**
     * @inheritdoc
     * @return ChampionSpellsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChampionSpellsQuery(get_called_class());
    }
}