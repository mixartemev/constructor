<?php

namespace backend\models;

use himiklab\sortablegrid\SortableGridBehavior;

/**
 * This is the model class for table "field".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_table
 * @property integer $id_type
 * @property integer $fk
 * @property integer $sort
 * @property int $id_group
 * @property bool $null
 * @property bool $signed
 * @property bool $unique
 *
 * @property Type $type
 * @property Table $table
 * @property Table $fkTable
 */
class Field extends Common
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'field';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sort'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_table'], 'required'],
            [['id_table', 'id_type', 'sort', 'fk'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['null', 'signed', 'unique'], 'boolean'],
            [['id_type'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['id_type' => 'id']],
            [['id_table', 'fk'], 'exist', 'skipOnError' => true, 'targetClass' => Table::className(), 'targetAttribute' => ['id_table' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'table.name' => 'Table',
            'type.name' => 'Type',
            'fk' => 'FK',
            'null' => 'Null',
            'signed' => 'Signed',
            'unique' => 'Unique',
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
    public function getFkTable()
    {
        return $this->hasOne(Table::className(), ['id' => 'fk'])->inverseOf('refs');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldGroup()
    {
        return $this->hasOne(FieldGroup::className(), ['id' => 'id_group'])->inverseOf('fields');
    }
}
