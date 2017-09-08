<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\cms\Category */

$this->title = '新建分类';
$this->params['breadcrumbs'][] = ['label' => '资讯分类列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->is_show = 1;
?>
<div class="category-create">
    <?= $this->render('_form', [
        'model' => $model,
        'categoryList' => $categoryList
    ]) ?>
</div>
