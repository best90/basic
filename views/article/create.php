<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\cms\Article */

$this->title = '新建文章';
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->is_top = 0;
$model->is_show = 1;
$model->author = $user['name'];
?>
<div class="news-create">
    <?= $this->render('_form', [
        'model' => $model,
        'categoryList' => $categoryList
    ]) ?>
</div>
