<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cms\Article */

$this->title = '编辑文章';
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $model->title];
?>
<div class="news-update">
    <?= $this->render('_form', [
        'model' => $model,
        'site' => $site,
        'categoryList' => $categoryList
    ]) ?>
</div>
