<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Field */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="field-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_type')->dropDownList(ArrayHelper::map(\backend\models\Type::find()->all(), 'id', 'name')) ?>

	<?= $form->field($model, 'null')->checkbox() ?>
	<?= $form->field($model, 'signed')->checkbox() ?>
	<?= $form->field($model, 'unique')->checkbox() ?>

	<?= $form->field($model, 'id_group')->dropDownList(ArrayHelper::map(\backend\models\FieldGroup::find()->all(), 'id', 'name'), ['prompt' => 'No Group']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
