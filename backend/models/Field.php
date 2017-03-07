<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "field".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_table
 * @property integer $id_type
 *
 * @property Type $type
 * @property Table $table
 * @property Relation[] $relations
 * @property Relation[] $relations0
 */
class Field extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_table'], 'required'],
            [['id_table', 'id_type'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_type'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['id_type' => 'id']],
            [['id_table'], 'exist', 'skipOnError' => true, 'targetClass' => Table::className(), 'targetAttribute' => ['id_table' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'table.name' => 'Таблица',
            'type.title' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'id_type'])->inverseOf('fields');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTable()
    {
        return $this->hasOne(Table::className(), ['id' => 'id_table'])->inverseOf('fields');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelations()
    {
        return $this->hasMany(Relation::className(), ['fk' => 'id'])->inverseOf('fk0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelations0()
    {
        return $this->hasMany(Relation::className(), ['pk' => 'id'])->inverseOf('pk0');
    }
}
