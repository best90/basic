<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\services\news\NewsService */
/* @var $form yii\widgets\ActiveForm */

if (!empty($params['title'])){
    $params['title'] = str_replace('"','&quot;', $params['title']);
    $params['title'] = str_replace("'",'&apos;', $params['title']);
}
?>
<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-inline">
        <div class="input-group col-md-3">
            <input type="text" id="title" class="form-control" placeholder="请输入用户ID、帐号、姓名、公司" name="keyword" value='<?=isset($params['keyword']) ? $params['keyword'] : '' ?>'>
        </div>
        <div class="form-group">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('清空', ['index'],['class' => 'btn btn-warning']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
