<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Junction */

$this->title = Yii::t('app', 'Create Junction');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Junctions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="junction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
