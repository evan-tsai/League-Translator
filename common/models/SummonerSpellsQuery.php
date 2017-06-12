<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SummonerSpells]].
 *
 * @see SummonerSpells
 */
class SummonerSpellsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SummonerSpells[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SummonerSpells|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}