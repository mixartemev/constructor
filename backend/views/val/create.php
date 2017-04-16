<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Val */

$this->title = Yii::t('app', 'Create Val');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="val-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
