<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "val".
 *
 * @property int $id
 * @property int $field_id
 * @property string $val
 * @property int $row_id
 *
 * @property Row $row
 * @property Field $field
 */
class Val extends \yii\db\ActiveRecord
{
	public static $types = [
		1 => ['textInput', 'number'],
		2 => ['textInput', 'number'],
		3 => ['textarea'],
		4 => ['checkbox'],
		5 => ['textInput', 'date'],
		6 => ['textInput', 'number'],
		6 => ['textInput', 'number'],
	];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'val';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_id', 'val', 'row_id'], 'required'],
            [['field_id', 'row_id'], 'integer'],
            [['val'], 'string', 'max' => 255],
            [['row_id'], 'exist', 'skipOnError' => true, 'targetClass' => Row::className(), 'targetAttribute' => ['row_id' => 'id']],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'field_id' => Yii::t('app', 'Field ID'),
            'val' => Yii::t('app', 'Val'),
            'row_id' => Yii::t('app', 'Row ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRow()
    {
        return $this->hasOne(Row::className(), ['id' => 'row_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }
}
