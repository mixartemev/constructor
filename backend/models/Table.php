<?php

namespace backend\models;

use himiklab\sortablegrid\SortableGridBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "table".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property int $sort
 * @property int $gen_crud
 * @property int $id_db
 *
 * @property Field[] $fields
 */
class Table extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'table';
    }

    /**
     * @inheritdoc
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
            [['name'], 'required'],
            [['name', 'title'], 'string', 'max' => 255],
            [['gen_crud'], 'integer'],
            [['sort'], 'integer'],
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
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFields()
    {
        return $this->hasMany(Field::className(), ['id_table' => 'id'])->inverseOf('table')->orderBy('sort');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefs()
    {
        return $this->hasMany(Field::className(), ['fk' => 'id'])->inverseOf('fkTable');
    }
}
