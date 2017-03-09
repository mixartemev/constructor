<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "relation".
 *
 * @property integer $id
 * @property integer $pk
 * @property integer $fk
 *
 * @property Field $fk0
 * @property Field $pk0
 */
class Relation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk', 'fk'], 'required'],
            [['pk', 'fk'], 'integer'],
            [['fk'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['fk' => 'id']],
            [['pk'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['pk' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pk' => 'Ссылочный ключ',
            'fk' => 'Внешний ключ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFk0()
    {
        return $this->hasOne(Field::className(), ['id' => 'fk'])->inverseOf('parentRelation');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPk0()
    {
        return $this->hasOne(Field::className(), ['id' => 'pk'])->inverseOf('childRelations');
    }
}
