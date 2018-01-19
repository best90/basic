<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\user\UserAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-account-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true, 'readonly'=>'true']) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '']) ?>

    <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('确认修改', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
