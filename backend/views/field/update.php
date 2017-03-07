<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Field */

$this->title = 'Update Field: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tables', 'url' => ['table/index']];
$this->params['breadcrumbs'][] = ['label' => $model->table->name, 'url' => ['table/view','id' => $model->id_table]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="field-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
