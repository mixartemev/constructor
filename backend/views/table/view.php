<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Table */
/* @var ActiveDataProvider $fieldDataProvider */

$this->title = $model->title ?: $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-view">

    <h1><?= Yii::t('app', 'Table') . $this->title ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= $this->render('../field/index', ['dataProvider' => $fieldDataProvider]) ?>

</div>
