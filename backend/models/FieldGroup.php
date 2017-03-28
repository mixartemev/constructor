<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "field_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $id_table
 * @property bool $collapsed
 *
 * @property Field[] $fields
 * @property Table $table
 */
class FieldGroup extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'field_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_table'], 'required'],
            [['id_table'], 'integer'],
            [['collapsed'], 'boolean'],
            [['name', 'title'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
            'collapsed' => Yii::t('app', 'Collapsed'),
            'id_table' => Yii::t('app', 'Table'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFields()
    {
        return $this->hasMany(Field::className(), ['id_group' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTable()
    {
        return $this->hasOne(Table::className(), ['id' => 'id_table']);
    }
}
