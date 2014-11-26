<?php

namespace frontend\modules\member;

use Yii;
use yii\base\module;
use yii\web\BadRequestHttpException;

class MemberModule extends Module
{
	// public $layout = '/main';
	public function init()
	{
		parent::init();
        \Yii::configure($this, require(__DIR__ . '/config.php'));
	}
}