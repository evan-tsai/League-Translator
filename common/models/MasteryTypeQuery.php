<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MasteryType]].
 *
 * @see MasteryType
 */
class MasteryTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MasteryType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MasteryType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}