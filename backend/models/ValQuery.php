<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Val]].
 *
 * @see Val
 */
class ValQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Val[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Val|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
