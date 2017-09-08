<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\cms\Category */
/* @var $form yii\widgets\ActiveForm */
$categoryList = ['当前默认为一级分类'] + $categoryList;
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['action' => '','method'=>'post']); ?>

    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_category_code')->dropDownList($categoryList, ['style'=>'width:25%']) ?>

    <?= $form->field($model, 'is_show')->radioList(['1'=>'显示','0'=>'隐藏']) ?>

    <?= $form->field($model, 'rank')->textInput() ?>

    <div class="form-group">
        <a href="/cms/category/index" class="btn btn-default">返回</a>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '添加') : Yii::t('app', '修改'), ['class' => 'btn btn-primary pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
