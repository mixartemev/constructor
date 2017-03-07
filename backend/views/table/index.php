<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tables';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Table', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'options' => ['width' => 30],
                'format' => 'raw',
                'value' =>  function($model,$key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        Yii::$app->getUrlManager()->createUrl(['table/update', 'id' => $key]),
                        ['title' => 'Редактирование таблицы ' . $model->name]
                    );
                }
            ],
            [
                'attribute' => 'id',
                'options' => ['width' => 50]
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model,$key){
                    return Html::a(
                        $model->name,
                        Yii::$app->getUrlManager()->createUrl(['table/view','id' => $key]),
                        ['title' => 'Просмотр таблицы '.$model->name]
                    );
                }
            ],
            [
                'options' => ['width' => 30],
                'format' => 'raw',
                'value' => function ($model,$key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        Yii::$app->getUrlManager()->createUrl(['table/delete','id' => $key]),
                        [
                            'title' => Yii::t('yii', 'Delete table '.$model->name),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                        ]
                    );
                }
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
