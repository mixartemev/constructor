<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FieldGroup */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Field Group',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Field Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="field-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
