<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\user\UserAccount */

$this->title = '修改密码';
$this->params['breadcrumbs'][] = '会员管理';
$this->params['breadcrumbs'][] = ['label' => '账户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $model->mobile];
?>
<div class="user-account-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
