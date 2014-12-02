<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\Menu */
$this->title = '菜单管理';
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){ }
    </script>

    <ul class="breadcrumb">
        <li>
            <?= Html::a('创建菜单', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
        </li>
    </ul><!-- /.breadcrumb -->
    <!-- /section:basics/content.searchbox -->
</div>
<div class="page-content">
    <!-- /section:settings.box -->
    <div class="page-content-area">
        <div class="page-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    <?= Html::encode($this->title) ?>
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <table class="table table-hover" id="menu-table">
                    <thead>
                        <tr>
                            <th>菜单</th><th>创建时间</th>
                            <th width="150"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menu as $k => $v):?>
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
                                            'confirm' => '确定要删除此菜单吗?',
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
$("#menu-table").treetable({ expandable: true });
</script>