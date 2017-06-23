<?php
/* @var $this yii\web\View */

$this->title = $title;
?>
<div class="site-index">
    <table class="table table-hover">
        <thead>
            <tr>
                <th colspan="2">供应商详情</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>供应商企业ID : </td>
                <td><?=$supplier->supplier_id ?></td>
            </tr>
            <tr>
                <td>公司名称 : </td>
                <td><?=$supplier->company_name ?></td>
            </tr>
            <tr>
                <td>主营业务 : </td>
                <td><?=$supplier->main_services ?></td>
            </tr>
            <tr>
                <td>认证时间 : </td>
                <td><?=$supplier->certification_time ?></td>
            </tr>
            <tr>
                <td>注册资本 : </td>
                <td><?=$supplier->reg_capital ?></td>
            </tr>
            <tr>
                <td>地区（省） : </td>
                <td><?=$supplier->area_name ?></td>
            </tr>
        </tbody>
    </table>
    <div class="col-lg-8">
        <a href="<?=Yii::$app->request->getReferrer(); ?>">
            <button type="button" class="btn btn-primary">返回</button>
        </a>
    </div>
</div>