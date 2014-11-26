<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->title = ' ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ads', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){ }
    </script>
<?php
echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
?><!-- /.breadcrumb -->
    <!-- /section:basics/content.searchbox -->
</div>

<div class="page-content">
	<!-- /section:settings.box -->
	<div class="page-content-area">
		<div class="page-header">
			<h1>编辑
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
					<?= Html::encode($this->title) ?>
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 ad-update">
				 <?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>
				<div class="hr hr-18 dotted hr-double"></div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content-area -->
</div>
