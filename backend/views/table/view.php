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

	<?= $this->render('../field/index', ['id_table' => $model->id]) ?>

</div>
