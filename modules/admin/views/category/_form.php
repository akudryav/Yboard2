<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin();

    echo $form->field($model, 'name')->textInput(['maxlength' => true]);
    echo $form->field($model, 'parentId')->widget(Select2::class, [
        'data' => Category::makeOptionsList($model->id),
        'options' => ['placeholder' => Yii::t('app', 'No Parent (saved as root)')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    echo $form->field($model, 'position')->textInput(['type' => 'number'])
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ?
            Yii::t('app', 'Create') :
            Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end();
    $script = <<< JS
$(document).on('beforeSubmit', 'form', function(event) {
    $(this).find('[type=submit]').attr('disabled', true).addClass('disabled');
});
JS;
    $this->registerJs($script, \yii\web\View::POS_READY);?>

</div>