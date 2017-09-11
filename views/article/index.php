<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;

echo Dialog::widget();
/* @var $this yii\web\View */
/* @var $searchModel app\services\cms\ArticleService */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="news-index well" style="padding: 10px 10px;height: auto;">
    <div class="col-sm-12" style="margin-bottom: 10px;">
        <?= Html::a('新建文章', ['create'], ['class' => 'btn btn-primary pull-right']) ?>
    </div>
    <br>
    <?php echo $this->render('_search', [
        'model' => $searchModel,
        'params' => $searchParams,
        'categoryList' => $categoryList,
        'users' => $users,
        'sites' => $sites
    ]); ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'options' => ['class' => 'grid-view','style'=>'overflow:auto', 'id' => 'grid'],
    'columns' => [
        [
            'class' => 'yii\grid\CheckboxColumn',
            'name' => 'id',
            'headerOptions' => ['width' => '50']
        ],
        [
            'attribute' => 'uid',
            'headerOptions' => ['width' => '50'],
        ],
        [
            'attribute' => 'title',
            'label' => '标题',
        ],
        [
            'attribute' => 'category_id',
            'label' => '分类',
            'headerOptions' => ['width' => '150'],
            'value' => function($data){
                return isset($data['category']['category_name']) ? $data['category']['category_name'] : '';
            },
        ],
        [
            'attribute' => 'is_top',
            'label' => '置顶',
            'headerOptions' => ['width' => '100'],
            'value' => function ($data) {
                switch ($data['is_top']){
                    case 0:
                        return '否';
                        break;
                    case 1:
                        return '是';
                        break;
                    default:
                        return '';
                }
            },
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
            'attribute' => 'view_num',
            'headerOptions' => ['width' => '100'],
        ],
        [
            'attribute' => 'create_by',
            'headerOptions' => ['width' => '120'],
            'value' => function($data){
                return isset($data['user']['name']) ? $data['user']['name'] : '';
            },
        ],
        [
            'attribute' => 'create_time',
            'headerOptions' => ['width' => '180'],

        ],
        [
            'class' => 'yii\grid\ActionColumn', 'header' => '操作', 'template' => '{update}  {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span> 编辑', ['update', 'id' => $model['uid']], ['title' => '编辑','class' => 'btn btn-success btn-xs']);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-floppy-remove"></span> 删除', 'javascript:void(0);', ['title' => '删除','class' => 'btn btn-danger btn-xs article-delete','data-id' => $model['uid']]);
                },
            ],
            'headerOptions' => ['width' => '150']
        ],
    ],
    'layout'=> '{items}<div class="text-right tooltip-demo">{summary}{pager}</div>',
    'pager'=>[
        'firstPageLabel'=>"首页",
        'prevPageLabel'=>'上一页',
        'nextPageLabel'=>'下一页',
        'lastPageLabel'=>'末页',
    ],
    'emptyText' => '没有筛选到任何内容哦！',
    'emptyTextOptions' => [
        'class' => 'empty',
        'style' => 'text-align:center;'
    ],
]);

$js = <<< JS
    $(".article-delete").on("click", function() {
        var id = $(this).attr('data-id');
        krajeeDialog.confirm("您确定删除该文章?", function (result) {
            if (result) {
                window.location.href = '/news/news/delete?id='+id;
            }
        });
    });
JS;
$this->registerJs($js);

$this->registerJs('
    $("#operate").on("change",function(){
         if($(this).val() === "move"){
            $("#category").parent().show();
         }else{
            $("#category").parent().hide();
         }
    });
    
    $(".gridview").on("click", function () {
        var keys = $("#grid").yiiGridView("getSelectedRows");
        var operate = $("#operate").val();
        if(operate === ""){
            $("#operate").css("border","1px solid red");
            return;
        }
        
        if(operate === "move"){
            $("#operate").css("border","");
            if($("#category").val() === ""){
                $("#category").css("border","1px solid red");
                return;
            }
        }
        if(keys.length < 1){
            krajeeDialog.alert("请选择要进行操作的文章选项！");
            return;
        }
        
        $("#operate").css("border","");
        $("#_uid").val(keys);
        
        switch(operate){
            case "move":
                $message = "您确定要移动分类吗？";
                break;
            case "delete":
                $message = "您确定要删除所选的文章吗？";
                break;
            case "hidden":
                $message = "您确定要隐藏所选的文章吗？";
                break;
            default:
                $message = "您确定要进行该操作吗？";
        }
        
        krajeeDialog.confirm($message, function (result) {
            if (result) {
                $("#operation-form").submit();
            }
        });
    });
');

$operateItems = ['' => '请选择','delete' => '批量删除','move' => '移动分类','hidden' => '隐藏'];
?>

<div class="form-group">
    <form id="operation-form" action="./operate" method="post">
        <div class="col-md-2">
            <?= Html::dropDownList('operate', null, $operateItems,['id' => 'operate','class' => 'form-control'])?>
        </div>
        <div class="col-md-2" style="display:none">
            <?= Html::dropDownList('category_id', null,['' => '请选择分类'] + $categoryList,['id' => 'category','class' => 'form-control'])?>
        </div>
        <input type="hidden" name="uid" id="_uid" value="">
        <?= Html::a('确定', "javascript:void(0);", ['class' => 'btn btn-primary gridview']) ?>
    </form>
</div>