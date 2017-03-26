<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Field[] $fields
 */
class Type extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required'],
            [['name'], 'string', 'max' => 63],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFields()
    {
        return $this->hasMany(Field::className(), ['id_type' => 'id'])->inverseOf('type');
    }
}
