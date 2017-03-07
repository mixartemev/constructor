<?php

use backend\models\Field;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $id_table int */

var_dump(Yii::$app->request->isAjax);
if(!Yii::$app->request->isAjax){
	$this->title = 'Fields';
	$this->params['breadcrumbs'][] = ['label' => 'Tables', 'url' => ['table/index']];
	$this->params['breadcrumbs'][] = ['label' => \backend\models\Table::findOne($id_table)->name, 'url' => ['table/view','id' => $id_table]];
	$this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="field-index">
	<?php Pjax::begin(); ?>
	<?= GridView::widget([
		'dataProvider' => Field::getDataProvider($id_table), //todo подумать как вынестив контроллеры и таблицы и поля
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
