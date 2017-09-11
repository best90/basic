<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\dialog\Dialog;

echo Dialog::widget();
/* @var $this yii\web\View */
/* @var $model app\models\cms\Article */
/* @var $form yii\widgets\ActiveForm */

$categoryList = ['' => '请选择分类'] + $categoryList;
?>
<div class="news-form">

    <?php $form = ActiveForm::begin(['id' => 'news-form']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryList, ['style' => 'width:25%']) ?>

    <?= $form->field($model, 'is_top', ['template' => "<div class='col-sm-1'>{label}</div><div class='col-sm-11'>{input}{error}</div>"])->radioList(['1' => '置顶', '0' => '不置顶']) ?>
    <br>
    <br>
    <?= $form->field($model, 'is_show', ['template' => "<div class='col-sm-1'>{label}</div><div class='col-sm-11'>{input}</div>"])->radioList(['1' => '显示', '0' => '隐藏']) ?>
    <br>
    <?= $form->field($model, 'author')->textInput(['maxlength' => true, 'style' => 'width:25%']) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true, 'style' => 'width:25%']) ?>

    <?php if ($model->crawl_site_id != 0) { ?>
        <div class="form-group">
            <span class="control-label col-md-1"><b>渠道</b> </span>
            <span class="col-md-1"><input type="radio" name="source" value="" checked> 抓取</span>
            <span class="col-md-8">渠道网址： <?= $site ?></span>
            <br>
        </div>
    <?php } ?>


    <?= $form->field($model, 'tag')->textInput(['maxlength' => true, 'style' => 'width:50%']) ?>

    <div class="form-group font_red">多个标签请以“,”隔开，最多5个</div>

    <?= $form->field($model, 'digest')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'img_src')->widget('app\common\widgets\webuploader\FileInput', [
    ]) ?>
    <p>尺寸建议210*110，格式为png，jpg，jpeg，gif</p>
    <br>

    <?= $form->field($model, 'content',['template' => "<div class='col-sm-1'>{label}</div><div style='color: #C00000;'>正文上传图片宽度最大不能超过718px，不能直接从微信文章复制图片到正文</div><br>{input}"])->widget('app\common\widgets\ueditor\UEditor', [
        'clientOptions' => [
            'initialFrameHeight' => 450,
            //'initialFrameWidth' => '95%',
            'lang'               => 'zh-cn', //中文为 zh-cn
        ]
    ]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-default']) ?>
        <div class="pull-right">
            <?= Html::button('预览', ['id' => 'preview', 'class' => 'btn btn-success']) ?>
            <?php if ($model->isNewRecord) { ?>
                <?= Html::button('发布', ['id' => 'news-publish', 'class' => 'btn btn-primary']) ?>
            <?php } else { ?>
                <?= Html::button('保存', ['id' => 'news-save', 'class' => 'btn btn-primary']) ?>
            <?php } ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<< JS
    $("#news-publish").on("click", function() {
        krajeeDialog.confirm("您确定发布当前文章吗?", function (result) {
            if (result) {
                $('#news-form').submit();
            }
        });
    });
    $("#news-save").on("click", function() {
        krajeeDialog.confirm("您确定修改当前文章吗?", function (result) {
            if (result) {
                $('#news-form').submit();
            }
        });
    });
    $('#preview').click(function(){
        $("#preview_title").val($("#news-title").val());
        $("#preview_content").val($("textarea[name='News[content]']:first").val());
        $('#btn-preview').click(); 
    });
JS;
$this->registerJs($js);
?>
