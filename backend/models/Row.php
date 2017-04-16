<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "row".
 *
 * @property int $id
 * @property int $table_id
 *
 * @property Table $table
 * @property Val[] $vals
 */
class Row extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'row';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'table_id'], 'required'],
            [['id', 'table_id'], 'integer'],
            [['table_id'], 'exist', 'skipOnError' => true, 'targetClass' => Table::className(), 'targetAttribute' => ['table_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table_id' => Yii::t('app', 'Table ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTable()
    {
        return $this->hasOne(Table::className(), ['id' => 'table_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVals()
    {
        return $this->hasMany(Val::className(), ['row_id' => 'id']);
    }
}
