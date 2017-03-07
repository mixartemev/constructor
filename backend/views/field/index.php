<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $id_table int */

$this->title = 'Fields';
$this->params['breadcrumbs'][] = ['label' => 'Tables', 'url' => ['table/index']];
$this->params['breadcrumbs'][] = ['label' => \backend\models\Table::findOne($id_table)->name, 'url' => ['table/view','id' => $id_table]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Field', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'table.name',
            'type.title',
            /*[
                'attribute'=>'type',
                'filter'=>ArrayHelper::map(\backend\models\Type::find()->all(), 'id', 'id_type'),
            ],*/


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
