<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "db".
 *
 * @property integer $id
 * @property string $name
 * @property string $user_id
 *
 * @property Table[] $tables
 */
class Db extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_user'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['id_user'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'id_user' => Yii::t('app', 'Owner'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTables()
    {
        return $this->hasMany(Table::className(), ['id_db' => 'id']);
    }
}
