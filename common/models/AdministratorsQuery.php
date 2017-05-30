<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Administrators]].
 *
 * @see Administrators
 */
class AdministratorsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Administrators[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Administrators|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}