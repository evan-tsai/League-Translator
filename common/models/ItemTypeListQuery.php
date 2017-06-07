<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ItemTypeList]].
 *
 * @see ItemTypeList
 */
class ItemTypeListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ItemTypeList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ItemTypeList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}