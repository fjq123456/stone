<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\Menu */

$this->title = $name;
// $this->params['breadcrumbs'] = [
//     ['label' => 'home', 'url' => ['index']],
// ];
?>
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){ }
    </script>
<?php
echo Breadcrumbs::widget([
    'links' => $this->params['breadcrumbs']
]);
?><!-- /.breadcrumb -->
    <!-- /section:basics/content.searchbox -->
</div>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="alert alert-danger">
                <?= nl2br(Html::encode($message)) ?>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>