<?php

use backend\models\Field;
use backend\models\Table;
use backend\models\Type;
use himiklab\sortablegrid\SortableGridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="field-index">
    <?php //Pjax::begin();
    /** @var \yii\db\ActiveQuery $query */
    $query = $dataProvider->query;
    $id_table = $query->where['id_table'];
    ?>
    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' =>true,
        'sortableAction' => ['/field/sort'],
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['width' => 50],
                'footer' => Html::beginForm(['/field/create', 'id_table' => $id_table])
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model,$key){
                    return Html::a(
                        $model->name,
                        Yii::$app->getUrlManager()->createUrl(['field/view','id' => $key]),
                        ['title' => 'Просмотр поля '.$model->name]
                    );
                },
                'footer' => Html::activeTextInput($newField = new Field(), 'name', ['class' => 'form-control', 'required' => true])
            ],
            [
                'attribute' => 'type.name',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a(
                        $model->type->name,
                        Yii::$app->getUrlManager()->createUrl(['type/view','id' => $model->id_type]),
                        ['title' => 'Просмотр типа '.$model->type->name]
                    );
                },
                'footer' => Html::activeDropDownList(
                    $newField,
                    'id_type',
                    ArrayHelper::map(Type::find()->all(), 'id', 'name'),
                    ['class' => 'form-control']
                )
            ],
            [
                'attribute' => 'parentRelation.pk',
                'format' => 'raw',
                'value' => function($model){
                    /** @var Field $model */
                    return $model->parentRelation
                        ? Html::a(
                            $model->parentRelation->pk0->name,
                            Yii::$app->getUrlManager()->createUrl(['table/view','id' => $model->parentRelation->pk]),
                            ['title' => 'Просмотр типа '.$model->type->name]
                        )
                        : '';
                },
                'footer' => Html::dropDownList(
                    'rel',
                    null,
                    ArrayHelper::map(Table::find()->where(['id_db' => $this->context->session->get('db')])->all(), 'id', 'name'),
                    ['class' => 'form-control', 'prompt' => 'No FK']
                )
            ],
            [
                'attribute' => 'null',
                'format' => 'raw',
                'value' => function($model){
                    /** @var Field $model */
                    return Html::checkbox('null', $model->null, ['disabled' => true]);
                },
                'footer' => Html::activeCheckbox(
                    $newField,
                    'null',
                    ['label' => false]
                )
            ],
            [
                'attribute' => 'signed',
                'format' => 'raw',
                'value' => function($model){
                    /** @var Field $model */
                    return Html::checkbox('null', $model->signed, ['disabled' => true]);
                },
                'footer' => Html::activeCheckbox(
                    $newField,
                    'signed',
                    ['label' => false]
                )
            ],
            [
                'options' => ['width' => 30],
                'format' => 'raw',
                'value' =>  function($model,$key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        Yii::$app->getUrlManager()->createUrl(['field/update', 'id' => $key]),
                        ['title' => 'Редактирование поля ' . $model->name]
                    );
                },
                'footer' => Html::submitButton('+', ['class' => 'btn btn-success'])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['width' => 30],
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url,$model,$key) {
                        /** @var Field $model */
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            Yii::$app->getUrlManager()->createUrl(['field/delete','id' => $key, 'id_table' => $model->id_table]),
                            [
                                'title' => Yii::t('yii', 'Delete field '.$model->name),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                            ]);
                    }
                ],
                'footer' => Html::endForm()
            ]
        ]
    ]); ?>
    <?php //Pjax::end(); ?>
</div>
