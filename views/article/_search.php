<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\services\cms\ArticleService */
/* @var $form yii\widgets\ActiveForm */

if (!empty($params['title'])){
    $params['title'] = str_replace('"','&quot;', $params['title']);
    $params['title'] = str_replace("'",'&apos;', $params['title']);
}
?>
<link rel="stylesheet" href="/themes/admin/css/base/jquery-ui-1.9.2.custom.min.css">
<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-inline">
        <div class="input-group col-md-2">
            <span class="input-group-addon">分类</span>
            <select class="input-md form-control" name="category_id">
                <option value="">请选择</option>
                <?php foreach ($categoryList as $cid => $category){ ?>
                    <option value="<?= $cid ?>" <?php if(isset($params['category_id']) && $cid == $params['category_id']) echo 'selected';?>><?= $category ?></option>
                <?php }?>
            </select>
        </div>
        <div class="input-group col-md-2">
            <span class="input-group-addon">显示</span>
            <select class="input-md form-control" name="is_show">
                <option value="">请选择</option>
                <option value="1" <?php if(isset($params['is_show']) && $params['is_show'] == 1) echo 'selected';?>>显示</option>
                <option value="0" <?php if(isset($params['is_show']) && $params['is_show'] != '' && $params['is_show'] == 0) echo 'selected';?>>隐藏</option>
            </select>
        </div>
        <div class="input-group col-md-2">
            <span class="input-group-addon">渠道</span>
            <select class="input-md form-control" name="source">
                <option value="">请选择</option>
                <option value="1" <?php if(isset($params['source']) && $params['source'] == 1) echo 'selected';?>>自建</option>
                <option value="2" <?php if(isset($params['source']) &&$params['source'] == 2) echo 'selected';?>>抓取</option>
            </select>
        </div>
        <div class="input-group col-md-3">
            <span class="input-group-addon">渠道网址</span>
            <select class="input-md form-control" name="crawl_site_id">
                <option value="">请选择</option>
                <?php foreach ($sites as $sid => $name){ ?>
                    <option value="<?= $sid ?>" <?php if(isset($params['crawl_site_id']) && $sid == $params['crawl_site_id']) echo 'selected';?>><?= $name ?></option>
                <?php }?>
            </select>
        </div>
        <div class="input-group col-md-2">
            <span class="input-group-addon">创建人</span>
            <select class="input-md form-control" name="create_by">
                <option value="">请选择</option>
                <?php foreach ($users as $uid => $name){ ?>
                    <option value="<?= $uid ?>" <?php if(isset($params['create_by']) && $uid == $params['create_by']) echo 'selected';?>><?= $name ?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <br>
    <div class="form-inline">
        <div class="input-group col-md-5">
            <span class="input-group-addon">创建时间</span>
            <input type="text" id="start_time" class="form-control" placeholder="开始时间" name="from" value="<?= isset($params['from']) ? $params['from'] : '' ?>">
            <span class="input-group-addon">到</span>
            <input type="text" id="end_time" class="form-control" placeholder="结束时间" name="to" value="<?= isset($params['to']) ? $params['to'] : '' ?>">
        </div>
        <div class="input-group col-md-5">
            <span class="input-group-addon">标题</span>
            <input type="text" id="title" class="form-control" placeholder="请输入文章标题" name="title" value='<?=isset($params['title']) ? $params['title'] : '' ?>'>
        </div>
        <div class="form-group">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('清空', ['index'],['class' => 'btn btn-warning']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<script src="/js/libs/jquery-1.12.4.min.js"></script>

<!--<script src="/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/js/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>-->

<script>
    $(function () {
        $("#start_time").datepicker({
            //showButtonPanel:true,
            changeMonth: true,
            dateFormat: "yy-mm-dd",//日期格式
            onClose: function( selectedDate ) {
                $( "#end_time" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $("#end_time").datepicker({
            //showButtonPanel:true,
            changeMonth: true,
            dateFormat: "yy-mm-dd",//日期格式
            onClose: function( selectedDate ) {
                $( "#start_time" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    });
</script>
