<?php

namespace frontend\modules\member\controllers;

use Yii;
use frontend\modules\member\models\Member;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * @title memberController
 */
class DefaultController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index',
				['model'=>$this->findModel()]
			);
	}

	public function abc()
	{
		echo 'sss';die;
	}

	protected function findModel()
    {
        if (($model = Member::findOne(Yii::$app->user->id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}