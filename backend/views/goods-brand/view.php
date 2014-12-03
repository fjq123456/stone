<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;
use common\models\Attachment;
/* @var $this yii\web\View */
/* @var $model common\models\GoodsBrand */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '商品品牌', 'url' => ['index']];
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
                <small>
                    详细信息查看
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-10 goods-brand-view">
                    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'categorystr',
            'name_cn',
            'name_en',
            [                    // the owner name of the model
                'label' => 'logo',
                'value' => Attachment::getUrl($model->logo, 'small'),
                'format' => 'image'
            ],
            'intro:ntext',
            'url:url',
            'story:ntext',
            'statustext',
            'created_at',
        ],
    ]) ?>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
            <div class="col-xs-2">
                <?= Html::a('编 辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('删 除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => '确定要删除此菜单吗',
                        'method' => 'post',
                    ],
                ]) ?>

            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>