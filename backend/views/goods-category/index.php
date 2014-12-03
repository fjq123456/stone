<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '商品分类');
$this->params['breadcrumbs'][] = $this->title;

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
<div class="pull-right">
    <a href="<?=Url::toRoute('create')?>" class="btn btn-primary btn-xs">新增分类</a>
</div>
</div>


<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small>
                    列表
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">

            <div class="col-xs-12 goods-category-index">
                <table class="table table-hover" id="category-table">
                    <thead>
                        <tr>
                            <th>分类</th>
                            <th>创建时间</th>
                            <th width="150"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cates as $k => $v):?>
                        <tr data-tt-id=<?=$v['id']?> data-tt-parent-id=<?=$v['pid']?>>
                            <td><?=$v['name']?></td>
                            <td><?=date('Y/m/d',$v['created_at'])?></td>
                            <td> 
                                <?= Html::a('编辑', ['update', 'id' => $v['id']],
                                    ['class' => 'btn btn-info btn-xs']
                                ) ?> 
                                <?= Html::a('删除', ['delete', 'id' => $v['id']], [
                                        'class' => 'btn btn-danger btn-xs',
                                        'data' => [
                                            'confirm' => '确定要删除此分类吗?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <div class="hr hr-18 dotted hr-double"></div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content-area -->
</div>
<?= Html::cssFile('static/js/tabletree/jquery.treetable.css') ?>
<?= Html::cssFile('static/js/tabletree/jquery.treetable.theme.default.css') ?>
<?= Html::jsFile('static/js/tabletree/jquery.treetable.js') ?>

<script type="text/javascript">
$("#category-table").treetable({ expandable: true });
</script>