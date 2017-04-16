<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Row */
/* @var $table_id int */

$this->title = Yii::t('app', 'Create Row');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'table_id' => $table_id
    ]) ?>

</div>
