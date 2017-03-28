<?php

use backend\models\Field;
use backend\models\FieldGroup;
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
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($model,$key){
                    return Html::a(
                        $model->title,
                        Yii::$app->getUrlManager()->createUrl(['field/view','id' => $key]),
                        ['title' => Yii::t('app', 'View field ') . $model->title]
                    );
                },
                'footer' => Html::activeTextInput($newField = new Field(), 'title', ['class' => 'form-control'])
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model,$key){
                    return Html::a(
                        $model->name,
                        Yii::$app->getUrlManager()->createUrl(['field/update','id' => $key]),
                        ['title' => Yii::t('app', 'Edit field ') . $model->name]
                    );
                },
                'footer' => Html::activeTextInput($newField = new Field(), 'name', ['class' => 'form-control', 'required' => true])
            ],
            [
                'attribute' => 'type.name',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a(
                        $model->type->title ?: $model->type->name,
                        Yii::$app->getUrlManager()->createUrl(['type/view','id' => $model->id_type]),
                        ['title' => Yii::t('app', 'View dataType ') . $model->type->title ?: $model->type->name]
                    );
                },
                'footer' => Html::activeDropDownList(
                    $newField,
                    'id_type',
                    ArrayHelper::map(Type::find()->all(), 'id', 'title'),
                    ['class' => 'form-control']
                )
            ],
            [
                'attribute' => 'fk',
                'format' => 'raw',
                'value' => function($model){
                    /** @var Field $model */
                    return $model->fk
                        ? Html::a(
                            $model->fkTable->title,
                            Yii::$app->getUrlManager()->createUrl(['table/view','id' => $model->fk]),
                            ['title' => Yii::t('app', 'View FK ') . $model->fkTable->title]
                        )
                        : '';
                },
                'footer' => Html::activeDropDownList(
                    $newField,
                    'fk',
					ArrayHelper::map(Table::find()->where(['id_db' => $this->context->session->get('db')])->all(), 'id', 'title'),
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
                    return Html::checkbox('signed', $model->signed, ['disabled' => true]);
                },
                'footer' => Html::activeCheckbox(
                    $newField,
                    'signed',
                    ['label' => false]
                )
            ],
            [
                'attribute' => 'unique',
                'format' => 'raw',
                'value' => function($model){
                    /** @var Field $model */
                    return Html::checkbox('unique', $model->unique, ['disabled' => true]);
                },
                'footer' => Html::activeCheckbox(
                    $newField,
                    'unique',
                    ['label' => false]
                )
            ],
            [
                'attribute' => 'id_group',
                'format' => 'raw',
                'value' => function($model){
                    /** @var Field $model */
                    return $model->id_group
                        ? Html::a(
                            $model->fieldGroup->title,
                            Yii::$app->getUrlManager()->createUrl(['table/view','id' => $model->id_group]),
                            ['title' => Yii::t('app', 'View group ').$model->fieldGroup->title]
                        )
                        : '';
                },
                'footer' => Html::activeDropDownList(
                    $newField,
                    'id_group',
                    ArrayHelper::map(FieldGroup::find()->where(['id_table' => Yii::$app->request->get('id')])->all(), 'id', 'title'),
                    ['class' => 'form-control', 'prompt' => Yii::t('app', 'No Group')]
                )
            ],
            [
                'attribute' => 'list_view',
                'format' => 'raw',
                'value' => function($model){
                    /** @var Field $model */
                    return Html::checkbox('list_view', $model->list_view, ['disabled' => true]);
                },
                'footer' => Html::activeCheckbox(
                    $newField,
                    'list_view',
                    ['label' => false]
                )
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
                                'title' => Yii::t('app', 'Delete field ') . $model->name,
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                            ]);
                    }
                ],
                'footer' => Html::submitButton('+', ['class' => 'btn btn-success']) . Html::endForm()
            ]
        ]
    ]); ?>
    <?php //Pjax::end(); ?>
</div>
