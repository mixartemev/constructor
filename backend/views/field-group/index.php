<?php

use backend\models\FieldGroup;
use backend\models\Table;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Field Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-group-index">

<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' =>true,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['width' => 50],
                'footer' => Html::beginForm('/field-group/create')
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($model,$key){
                    return Html::a(
                        $model->title,
                        Yii::$app->getUrlManager()->createUrl(['field-group/view','id' => $key]),
                        ['title' => 'Просмотр группы '.$model->title]
                    );
                },
                'footer' => Html::activeTextInput(($newGroup = new FieldGroup()), 'title', ['class' => 'form-control', 'required' => true])
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model,$key){
                    return Html::a(
                        $model->name,
                        Yii::$app->getUrlManager()->createUrl(['field-group/update','id' => $key]),
                        ['title' => 'Изменение группы '.$model->name]
                    );
                },
                'footer' => Html::activeTextInput($newGroup, 'name', ['class' => 'form-control', 'required' => true])
            ],
            [
                'attribute' => 'id_table',
                'format' => 'raw',
                'value' => function($model){
                    /** @var FieldGroup $model */
                    return Html::a(
                            $model->table->title,
                            Yii::$app->getUrlManager()->createUrl(['table/view','id' => $model->id_table]),
                            ['title' => 'Просмотр таблицы '.$model->table->title]
                        );
                },
                'footer' => Html::activeDropDownList(
                    $newGroup,
                    'id_table',
                    ArrayHelper::map(Table::find()->where(['id_db' => $this->context->session->get('db'), 'gen_crud' => 1])->all(), 'id', 'title'),
                    ['class' => 'form-control']
                )
            ],
            [
                'attribute' => 'collapsed',
                'format' => 'raw',
                'value' => function($model){
                    /** @var FieldGroup $model */
                    return Html::checkbox('collapsed', $model->collapsed, ['disabled' => true]);
                },
                'footer' => Html::activeCheckbox(
                    $newGroup,
                    'collapsed',
                    ['label' => false]
                )
            ],
            [
                'options' => ['width' => 30],
                'format' => 'raw',
                'value' => function ($model,$key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        Yii::$app->getUrlManager()->createUrl(['field-group/delete','id' => $key]),
                        [
                            'title' => Yii::t('yii', 'Delete group '.$model->name),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                        ]
                    );
                },
                'footer' => Html::submitButton('+', ['class' => 'btn btn-success']) . Html::endForm()
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
