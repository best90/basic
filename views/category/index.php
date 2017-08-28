<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;

echo Dialog::widget();
/* @var $this yii\web\View */
/* @var $searchModel app\services\category\CategoryService */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '资讯分类管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index well" style="padding: 10px 10px;height: 55px;">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Html::a('新建分类', ['create'], ['class' => 'btn btn-primary pull-right']) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['width' => '30']
        ],
        [
            'attribute' => 'category_name',
            'label' => '分类',
            'headerOptions' => ['width' => '300']
        ],
        [
            'attribute' => 'is_show',
            'label' => '显示',
            'headerOptions' => ['width' => '100'],
            'value' => function ($data) {
                switch ($data['is_show']){
                    case 0:
                        return '隐藏';
                        break;
                    case 1:
                        return '显示';
                        break;
                    default:
                        return '';
                }
            },
        ],
        [
            'attribute' => 'rank',
            'label' => '排序',
            'headerOptions' => ['width' => '100'],
            'value' => function($data){
                return $data['rank'] ? $data['rank'] : '';
            },
        ],
        [
            'attribute' => 'user_name',
            'label' => '创建人',
            'headerOptions' => ['width' => '100'],
            'value' => function($data){
                return $data['user_name'] ? $data['user_name'] : '';
            },
        ],
        [
            'attribute' => 'create_time',
            'label' => '创建时间',
            'headerOptions' => ['width' => '150'],
            'value' => function($data){
                return $data['create_time'] ? $data['create_time'] : '';
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn', 'header' => '操作', 'template' => '{update}  {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span> 编辑', ['update', 'id' => $model['category_code']], ['title' => '编辑','class' => 'btn btn-success btn-xs']);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-floppy-remove"></span> 删除', 'javascript:void(0);', ['title' => '删除','class' => 'btn btn-danger btn-xs category-delete','data-id' => $model['category_code']]);
                },
            ],
            'headerOptions' => ['width' => '100']
        ],
    ],
    'layout'=> '{items}<div class="text-right tooltip-demo">{pager}</div>',
    'pager'=>[
        'firstPageLabel'=>"首页",
        'prevPageLabel'=>'上一页',
        'nextPageLabel'=>'下一页',
        'lastPageLabel'=>'末页',
    ],
    'emptyText' => '没有筛选到任何内容哦！',
]);

$js = <<< JS
    $(".category-delete").on("click", function() {
        var id = $(this).attr('data-id');
        krajeeDialog.confirm("您确定删除该分类?", function (result) {
            if (result) {
                window.location.href = '/news/category/delete?id='+id;
            }
        });
    });
JS;
$this->registerJs($js);
?>
