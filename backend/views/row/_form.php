<?php

use backend\models\Field;
use backend\models\Val;
use yii\helpers\ArrayHelper;
use backend\models\Table;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Row */
/* @var $form yii\widgets\ActiveForm */
/* @var $table_id int */
?>

<div class="row-form">

    <?php $form = ActiveForm::begin(['layout' => 'inline']);
    foreach ( Field::findAll(['id_table' => $table_id]) as $field) {
        //var_dump($field);
        echo $form->field(new Val(), 'val')->textInput(['placeholder' => $field->name]);
    }
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
