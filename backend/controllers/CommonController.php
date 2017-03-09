<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * CommonController
 *
 * @property Session $session
 */
class CommonController extends Controller
{
    /**
     * @return Session
     */
    public function getSession()
    {
        return Yii::$app->session;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
}
