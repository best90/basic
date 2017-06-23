<?php
use yii\grid\GridView;
/* @var $this yii\web\View */

$this->title = $title;
?>
<div class="site-index">
    <table class="table table-hover">
        <!--<thead>
            <tr>
                <th>序号</th>
                <th>供应商企业ID</th>
                <th>公司名称</th>
                <th>主营业务</th>
                <th>认证时间</th>
                <th>注册资本</th>
                <th>地区（省）</th>
                <th>操作</th>
            </tr>
        </thead>-->
        <tbody>
        <?php /*foreach ($list as $i => $item) { */?><!--
            <tr>
                <td><?/*=$i */?></td>
                <td><?/*=$item->supplier_id */?></td>
                <td><?/*=$item->company_name */?></td>
                <td><?/*=$item->main_services */?></td>
                <td><?/*=$item->certification_time */?></td>
                <td><?/*=$item->reg_capital */?></td>
                <td><?/*=$item->area_name */?></td>
                <td>
                    <a href=""><button type="button" class="btn btn-primary">编辑</button></a>
                    <a href=""><button type="button" class="btn btn-danger">删除</button></a>
                </td>
            </tr>
        --><?php /*}*/?>

        <?= GridView::widget([
            'dataProvider' => $provider,
            //'filterModel' => $list,
            'columns' => [
                [
                    'attribute' => 'supplier_id',
                    'label' => '供应商企业ID',
                ],
                [
                    'attribute' => 'company_name',
                    'label' => '公司名称',
                ],
                [
                    'attribute' => 'main_services',
                    'label' => '主营业务',
                ],
                [
                    'attribute' => 'certification_time',
                    'label' => '认证时间',
                ],
                [
                    'attribute' => 'reg_capital',
                    'label' => '注册资本',
                ],
                [
                    'attribute' => 'area_name',
                    'label' => '地区（省）',
                ],
                [
                    'header' => '操作',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                ],
            ],
        ]); ?>
        </tbody>
    </table>
</div>