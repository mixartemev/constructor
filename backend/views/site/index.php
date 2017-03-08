<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = Yii::$app->session->get('db') ?: Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>You can create</h1>

        <p class="lead">Your Yii-powered application</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to('/db/index') ?>">Get started with PG</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>1st step</h2>

                <p>Create your db, tables with fields of dataTypes with relations in simplest tabular editor</p>

                <p><a class="btn btn-default" href="<?= Url::to('/table/index') ?>">Tables &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>2nd step</h2>

                <p>Generate shell script from your schema in 1 click, and run it</p>

                <p><a class="btn btn-default" href="<?= Url::to('/table/gen') ?>">Generate sh &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>3rd step</h2>

                <p>Enjoy your created application, and manual edit it</p>

                <p><a class="btn btn-default" href="#">My app &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
