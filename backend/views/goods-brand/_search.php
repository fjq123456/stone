<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\SearchBrand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-brand-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options'=> [
            'class'=>'form-inline'
        ]
    ]); ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'name_cn') ?>

    <?= $form->field($model, 'name_en') ?>

    <?php echo $form->field($model, 'status') ?>


    <div class="form-group">
        <?= Html::submitButton('查 找', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
