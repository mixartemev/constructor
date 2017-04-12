<?php

use yii\helpers\ArrayHelper;
use backend\models\Table;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Junction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="junction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 't1')->dropDownList(ArrayHelper::map(Table::find()->where(['id_db' => $this->context->session->get('db')])->all(), 'id', 'name')) ?>
    <?= $form->field($model, 't2')->dropDownList(ArrayHelper::map(Table::find()->where(['id_db' => $this->context->session->get('db')])->all(), 'id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
