<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'pid')->dropDownList($model->getMenu(),['class'=>'form-control']) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'app_name')->dropDownList($model->getApps(),['class'=>'form-control app_name']) ?>
    <?= $form->field($model, 'controller_name')->dropDownList($model->getControllers($model->app_name),['class'=>'form-control controller_name']) ?>
    <?= $form->field($model, 'action_name')->dropDownList($model->getActions($model->app_name.'_'.$model->controller_name),['class'=>'form-control action_name']) ?>
    <?= $form->field($model, 'icon')->textInput(['maxlength' => 64]) ?>
    <?= $form->field($model, 'sort')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="hidden">
    <a href="<?=Url::toRoute('/menu/default/child');?>" class="create-role"></a>
    <input class="action" value="<?=Yii::$app->controller->action->id?>">
</div>
<script type="text/javascript">
$(function(){
    if ($('.action').val() == 'create') {
        getContent($('.app_name').val());
    };
    $('body').on('change blur','.app_name',function(e){
        var parent = $(this).val();
        getContent(parent);
    });
    $('body').on('change blur','.controller_name',function(e){
        var parent = $('.app_name').val() +'_'+ $(this).val();
        getContent(parent);
    });
})
    
function getContent(parent)
{
    var url = $('.create-role').attr('href');
    $.get(url, {appname:parent}, function(xhr){
        if (xhr.status) {
            if (xhr.data.controller) {
                var html = '';
                for (i in xhr.data.controller) {
                    html += '<option value="'+i+'">'+i+'</option>'
                };
                $('.controller_name').html(html);
            };
            var action = '';
            for (i in xhr.data.actions) {
                action += '<option value="'+i+'">'+i+'</option>'
            };
            $('.action_name').html(action);
        };
    }, 'json');
}


</script>