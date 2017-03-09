<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Session;

/**
 * This is the common model class for all table
 *
 * @property Session $session
 */
class Common extends ActiveRecord
{
	/**
	 * @return Session
	 */
	public function getSession()
	{
		return Yii::$app->session;
	}
}
