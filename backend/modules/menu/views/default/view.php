<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\Menu */

$this->title = Html::a($model->name, ['view', 'id' => $model->id]);
$this->params['breadcrumbs'] = [
    ['label' => '列表', 'url' => ['index']],
    ['label' => '添加新菜单', 'url' => ['create']],
];
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
            <h1><?= $this->title ?>
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    详细信息
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-10">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'app_name',
                            'auth_name',
                            'pid',
                            'module_name',
                            'controller_name',
                            'action_name',
                            'icon',
                            'sort',
                            'created_at',
                            'status',
                        ],
                    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
            <div class="col-xs-2">
                <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '确定要删除此菜单吗?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>