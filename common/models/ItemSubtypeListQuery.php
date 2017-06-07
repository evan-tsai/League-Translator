<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ItemSubtypeList]].
 *
 * @see ItemSubtypeList
 */
class ItemTypeListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ItemSubtypeList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ItemSubtypeList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}