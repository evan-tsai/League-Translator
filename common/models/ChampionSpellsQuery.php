<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ChampionSpells]].
 *
 * @see ChampionSpells
 */
class ChampionSpellsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ChampionSpells[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ChampionSpells|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}