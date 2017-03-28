<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Field */

$this->title = 'Update Field: ' . ($name = $model->title ?: $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tables'), 'url' => ['table/index']];
$this->params['breadcrumbs'][] = ['label' => $model->table->title, 'url' => ['table/view','id' => $model->id_table]];
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="field-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
