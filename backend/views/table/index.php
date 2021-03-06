<?php

use backend\models\Table;
use himiklab\sortablegrid\SortableGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tables');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-index">
    <?php Pjax::begin(); ?>
    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter' =>true,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['width' => 50],
                'footer' => Html::beginForm('/table/create')
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($model,$key){
                    return Html::a(
                        $model->title,
                        Yii::$app->getUrlManager()->createUrl(['table/view','id' => $key]),
                        [
                            'title' => Yii::t('app', 'View table ') . $model->title,
                            'class' => $model->gen_crud ? '' : 'black'
                        ]
                    );
                },
                'footer' => Html::activeTextInput(($newTable = new Table()), 'title', ['class' => 'form-control'])
            ],
            [
                'attribute' => 'name',
                'footer' => Html::activeTextInput($newTable, 'name', ['class' => 'form-control', 'required' => true])
            ],
            [
                'attribute' => 'gen_crud',
                'format' => 'raw',
                'value' => function($model){
                    /** @var Table $model */
                    return Html::checkbox('gen_crud', $model->gen_crud, ['disabled' => true]);
                },
                'footer' => Html::activeCheckbox(
                    $newTable,
                    'gen_crud',
                    ['label' => false]
                )
            ],
            [
                'options' => ['width' => 30],
                'format' => 'raw',
                'value' => function ($model,$key) {
                    return Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>',
                        Yii::$app->getUrlManager()->createUrl(['table/delete','id' => $key]),
                        [
                            'title' => Yii::t('app', 'Delete table '.$model->name),
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
