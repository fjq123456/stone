<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CategoryGoods;
/* @var $this yii\web\View */
/* @var $model common\models\GoodsBrand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-brand-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(CategoryGoods::getPids(false)) ?>

    <?= $form->field($model, 'name_cn')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'logo')->textInput(['maxlength' => 255])->fileInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'story')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创 建' : '保 存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
