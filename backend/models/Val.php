<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "val".
 *
 * @property int $id
 * @property int $field_id
 * @property string $val
 *
 * @property Field $field
 */
class Val extends \yii\db\ActiveRecord
{
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
            [['field_id', 'val'], 'required'],
            [['field_id'], 'integer'],
            [['val'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }

    /**
     * @inheritdoc
     * @return ValQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ValQuery(get_called_class());
    }
}
