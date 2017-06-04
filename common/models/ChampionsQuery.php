<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Champions]].
 *
 * @see Champions
 */
class ChampionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Champions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Champions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}