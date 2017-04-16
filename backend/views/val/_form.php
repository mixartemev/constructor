<?php

use yii\helpers\ArrayHelper;
use backend\models\Row;
use backend\models\Field;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Val */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="val-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'field_id')->dropDownList(ArrayHelper::map(Field::find()->all(),'id', 'name')) ?>

    <?= $form->field($model, 'val')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'row_id')->dropDownList(ArrayHelper::map(Row::find()->all(),'id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
