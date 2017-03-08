<?php

use backend\models\Field;
use backend\models\Type;
use himiklab\sortablegrid\SortableGridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="field-index">
	<?php //Pjax::begin(); ?>
	<?= SortableGridView::widget([
		'dataProvider' => $dataProvider,
		'showFooter' =>true,
        'sortableAction' => ['/field/sort'],
		'columns' => [
			[
				'attribute' => 'id',
				'options' => ['width' => 50],
				'footer' => Html::beginForm(['/field/create', 'id_table' => $dataProvider->query->where['id_table']])
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
				'attribute' => 'type.title',
				'format' => 'raw',
				'value' => function($model){
					return Html::a(
						$model->type->name,
						Yii::$app->getUrlManager()->createUrl(['type/view','id' => $model->id_type]),
						['title' => 'Просмотр типа '.$model->type->name]
					);
				},
				'footer' => Html::activeDropDownList($newField, 'id_type', ArrayHelper::map(Type::find()->all(), 'id', 'name'), ['class' => 'form-control'])
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
	<?php //Pjax::end(); ?></div>
