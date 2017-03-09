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
 * @property integer $sort
 * @property string $null
 * @property string $signed
 *
 * @property Type $type
 * @property Table $table
 * @property Relation $parentRelation
 * @property Relation[] $childRelations
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

    public $rel;

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
            [['id_table', 'id_type', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['null', 'signed'], 'boolean'],
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
            'name' => 'Name',
            'table.name' => 'Table',
            'type.name' => 'Type',
            'relation.name' => 'Type',
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
    public function getParentRelation()
    {
        return $this->hasOne(Relation::className(), ['fk' => 'id'])->inverseOf('fk0');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildRelations()
    {
        return $this->hasMany(Relation::className(), ['pk' => 'id'])->inverseOf('pk0');
    }

    public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);
		if($pk = \Yii::$app->request->post('Field')['rel']){ //ToDo wtf I do it through POST instead model attr
			$cond = ['fk' => $this->id, 'pk' => $pk];
			$rel = $insert ? new Relation($cond) : Relation::findOne($cond);
			if($rel->save()){
				$this->session->setFlash('success', 'Relation saved');
			}else{
				$this->session->setFlash('error', 'Relation not saved');
			}
		}
	}
}
