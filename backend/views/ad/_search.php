<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SearchAd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options'=> [
            'class'=>'form-inline'
        ]
    ]); ?>

    <?= $form->field($model, 'title') ?>
    <?php echo $form->field($model, 'res_name') ?>

    <?php echo $form->field($model, 'status')->dropDownList($model->getStatusList()) ?>
    <div class="form-group">
        <?= Html::submitButton('查 找', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
