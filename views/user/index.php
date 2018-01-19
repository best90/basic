<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\services\user\UserService */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '账户管理';
$this->params['breadcrumbs'][] = '会员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-index">
    <div class="well">
    <?php echo $this->render('_search', ['model' => $searchModel,'params' => $searchParams]); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'user_id',
            'register_source',
            [
                'attribute' => 'mobile',
                'label' => '帐号(手机)',
                'headerOptions' => ['width' => '120'],
                'value' => function($data){
                    return $data['userAccount']['mobile'] ? substr($data['userAccount']['mobile'],0, 7).'****' : '';
                },
            ],
            [
                'attribute' => 'name',
                'label' => '名字',
                'headerOptions' => ['width' => '120'],
                'value' => function($data){
                    return $data['businessCardRecord']['name'] ? $data['businessCardRecord']['name'] : '';
                },
            ],
            [
                'attribute' => 'position',
                'label' => '职务',
                'headerOptions' => ['width' => '120'],
                'value' => function($data){
                    return $data['businessCardRecord']['postion'] ? $data['businessCardRecord']['postion'] : '';
                },
            ],
            [
                'attribute' => 'mail',
                'label' => '邮箱',
                'headerOptions' => ['width' => '120'],
                'value' => function($data){
                    return $data['businessCardRecord']['mail'] ? $data['businessCardRecord']['mail'] : '';
                },
            ],
            [
                'attribute' => 'user_level',
                'headerOptions' => ['width' => '100'],
                'value' => function($data){
                    switch ($data['user_level']){
                        case 0:
                            return '无';
                        case 1:
                            return '认证会员';
                        case 2:
                            return '金牌供应商';
                        case 3:
                            return '金牌采购商';
                        default:
                            return '';
                    }
                },
            ],
            [
                'attribute' => 'company_name',
                'label' => '公司名称',
                'headerOptions' => ['width' => '200'],
                'value' => function($data){
                    return $data['businessCardRecord']['company_name'] ? $data['businessCardRecord']['company_name'] : '';
                },
            ],
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '120'],
                'value' => function($data){
                    switch ($data['status']){
                        case 1:
                            return '禁用';
                        case 2:
                            return '激活';
                        default:
                            return '';
                    }
                },
            ],
            'register_time',
            [
                'class' => 'yii\grid\ActionColumn', 'header' => '操作', 'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> 修改密码', ['update-password', 'id' => $model['user_id']], ['title' => '修改密码','class' => 'btn btn-success btn-xs']);
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
    ]); ?>
</div>
