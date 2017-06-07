<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ItemType]].
 *
 * @see ItemType
 */
class ItemTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ItemType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ItemType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}