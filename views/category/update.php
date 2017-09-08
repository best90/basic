<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cms\Category */

$this->title = '编辑分类';
$this->params['breadcrumbs'][] = ['label' => '资讯分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = '编辑分类';
?>
<div class="category-update">
    <?= $this->render('_form', [
        'model' => $model,
        'categoryList' => $categoryList
    ]) ?>
</div>
