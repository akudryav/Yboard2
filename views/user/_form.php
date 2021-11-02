<?php
/* @var $this ReviewsController */
/* @var $model Reviews */

/* @var $form CActiveForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="form">

    <?php
    $form = ActiveForm::begin(array(
        'id' => 'reviews-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><?= Yii::t('app', 'Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>

    <div>
        <?php echo $form->field($model, 'full_name')->textInput(); ?>
    </div>

    <div>
        <?php echo $form->field($model, 'location')->textInput(); ?>
    </div>
    <div>
        <?php echo $form->field($model, 'phone')->textInput(array('pattern' => '\+?[-0-9]+')); ?>
    </div>
    <div>
        <?php echo $form->field($model, 'skype')->textInput(); ?>
    </div>
    <div>
        <?php echo $form->field($model, 'contacts')->textInput(); ?>
    </div>


    <div class="row buttons">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), array('class' => 'btn')); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->