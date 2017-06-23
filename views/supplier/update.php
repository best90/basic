<?php
/* @var $this yii\web\View */

$this->title = $title;
?>
<div class="site-index">
    <?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    $form = ActiveForm::begin([
        'id' => 'supplier-form',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
    <?= $form->field($supplier, 'supplier_id')->label('供应商企业ID :') ?>
    <?= $form->field($supplier, 'company_name')->label('公司名称 :') ?>
    <?= $form->field($supplier, 'main_services')->label('主营业务 :') ?>
    <?= $form->field($supplier, 'certification_time')->label('认证时间 :') ?>
    <?= $form->field($supplier, 'reg_capital')->label('注册资本 :') ?>
    <?= $form->field($supplier, 'area_name')->label('地区（省） :') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <a href="<?=Yii::$app->request->getReferrer(); ?>">
                <button type="button" class="btn btn-primary">返回</button>
            </a>
            <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
    <!--<table class="table table-hover">
        <thead>
            <tr>
                <th colspan="2">供应商详情</th>
            </tr>
        </thead>
        <tbody>
        <form action="" method="post">
            <tr>
                <td>供应商企业ID : </td>
                <td><?/*=$supplier->supplier_id */?></td>
            </tr>
            <tr>
                <td>公司名称 : </td>
                <td><input type="text" class="form-control" name="company_name" value="<?/*=$supplier->company_name */?>"></td>
            </tr>
            <tr>
                <td>主营业务 : </td>
                <td><input type="text" class="form-control" name="main_services" value="<?/*=$supplier->main_services */?>"></td>
            </tr>
            <tr>
                <td>认证时间 : </td>
                <td><?/*=$supplier->certification_time */?></td>
            </tr>
            <tr>
                <td>注册资本 : </td>
                <td><input type="text" class="form-control" name="reg_capital" value="<?/*=$supplier->reg_capital */?>"></td>
            </tr>
            <tr>
                <td>地区（省） : </td>
                <td><input type="text" class="form-control" name="area_name" value="<?/*=$supplier->area_name */?>"></td>
            </tr>
            <tr>
                <td>
                    <a href="<?/*=Yii::$app->request->getReferrer(); */?>">
                        <button type="button" class="btn btn-primary">返回</button>
                    </a>
                </td>
                <td><input type="submit" class="btn btn-success" name="提交"></td>
            </tr>
        </form>
        </tbody>
    </table>-->
</div>