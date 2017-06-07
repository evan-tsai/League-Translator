<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ItemMap]].
 *
 * @see ItemMap
 */
class ItemMapQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ItemMap[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ItemMap|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}