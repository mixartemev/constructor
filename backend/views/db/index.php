<?php

use backend\models\Db;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Dbs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="db-index">
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' => true,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['width' => 50],
                'footer' => Html::beginForm('/db/create')
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model,$key){
                    return Html::a(
                        $model->name,
                        Yii::$app->getUrlManager()->createUrl(['db/view','id' => $key]),
                        ['title' => 'Просмотр таблицы '.$model->name]
                    );
                },
                'footer' => Html::activeTextInput(new Db(), 'name', ['class' => 'form-control', 'required' => true])
            ],
            [
                'options' => ['width' => 30],
                'format' => 'raw',
                'value' =>  function($model,$key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-check"></span>',
                        Yii::$app->getUrlManager()->createUrl(['db/check', 'id' => $key]),
                        [
                            'title' => 'Check DB ' . $model->name,
                            //'data-method' => 'get',
                        ]
                    );
                },
            ],
            [
                'options' => ['width' => 30],
                'format' => 'raw',
                'value' =>  function($model,$key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        Yii::$app->getUrlManager()->createUrl(['db/update', 'id' => $key]),
                        ['title' => 'Edin name ' . $model->name]
                    );
                },
                'footer' => Html::submitButton('+', ['class' => 'btn btn-success'])
            ],
            [
                'options' => ['width' => 30],
                'format' => 'raw',
                'value' => function ($model,$key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        Yii::$app->getUrlManager()->createUrl(['db/delete','id' => $key]),
                        [
                            'title' => Yii::t('yii', 'Delete db '.$model->name),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                        ]
                    );
                },
                'footer' => Html::endForm()
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
