<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
    'clientOptions' => [
        'initialFrameHeight' => 100,
        'toolbar' => [
            'source | undo redo | bold |',
            'link unlink | emotion image video |',
            'justifyleft justifycenter justifyright justifyjustify |',
            'insertorderedlist insertunorderedlist |' ,
            'horizontal preview fullscreen',
        ],
    ]
])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>