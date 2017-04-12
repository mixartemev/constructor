<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "junction".
 *
 * @property int $id
 * @property int $t1 Таблица1
 * @property int $t2 Таблица2
 *
 * @property Table $t20
 * @property Table $t10
 */
class Junction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'junction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t1', 't2'], 'required'],
            [['t1', 't2'], 'integer'],
            [['t2'], 'exist', 'skipOnError' => true, 'targetClass' => Table::className(), 'targetAttribute' => ['t2' => 'id']],
            [['t1'], 'exist', 'skipOnError' => true, 'targetClass' => Table::className(), 'targetAttribute' => ['t1' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            't1' => 'Таблица1',
            't2' => 'Таблица2',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT20()
    {
        return $this->hasOne(Table::className(), ['id' => 't2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT10()
    {
        return $this->hasOne(Table::className(), ['id' => 't1']);
    }
}
