<?php

use backend\models\Field;
use yii\data\ActiveDataProvider;

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Table */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => Field::find()->where(['id_table' => $model->id])->joinWith('type'),
]);

/**
 * Настройка параметров сортировки
 * Важно: должна быть выполнена раньше $this->load($params)
 * statement below
 */
$dataProvider->setSort([
    'attributes' => [
        'id','name','type.title'
    ]
]);
?>
<div class="table-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

    <div class="field-index">

        <p>
            <?= Html::a('Create Field', ['/field/create', 'id_table' => $model->id], ['class' => 'btn btn-success']) ?>
        </p>
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'options' => ['width' => 30],
                    'format' => 'raw',
                    'value' =>  function($model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->getUrlManager()->createUrl(['field/update', 'id' => $key]),
                            ['title' => 'Редактирование поля ' . $model->name]
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
                            Yii::$app->getUrlManager()->createUrl(['field/view','id' => $key]),
                            ['title' => 'Просмотр поля '.$model->name]
                        );
                    }
                ],
                [
                    'attribute' => 'type.title',
                    'format' => 'raw',
                    'value' => function($model){
                        return Html::a(
                            $model->type->title,
                            Yii::$app->getUrlManager()->createUrl(['type/view','id' => $model->id_type]),
                            ['title' => 'Просмотр типа '.$model->type->name]
                        );
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'options' => ['width' => 30],
                    //'format' => 'row',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url,$model,$key) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                Yii::$app->getUrlManager()->createUrl(['field/delete','id' => $key, 'id_table' => $model->id_table]),
                                [
                                    'title' => Yii::t('yii', 'Delete field '.$model->name),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                ]);
                        }
                    ]
                ]
            ]
        ]); ?>
        <?php Pjax::end(); ?></div>

</div>
