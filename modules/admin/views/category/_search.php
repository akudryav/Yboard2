<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */

use yii\bootstrap4\ActiveForm;

?>

<div class="wide form">

    <?php
    $form = ActiveForm::begin( array(
        'action' => Url::to($this->route),
        'method' => 'get',
        'options' => array('class' => 'well'),
    ));
    ?>

    <div class="row">
        <?php echo $form->field($model, 'id')->textInput(); ?>
    </div>

    <div class="row">
        <?php echo $form->field($model, 'name', array('size' => 60, 'maxlength' => 255))->textInput(); ?>
    </div>

    <div class="row">
        <?php echo $form->field($model, 'icon', array('size' => 60, 'maxlength' => 255))->textInput(); ?>
    </div>

    <div class="row">
        <?php echo $form->field($model, 'level', array('size' => 60, 'maxlength' => 255))->textInput(); ?>
    </div>

    <div class="row buttons">
        <?php echo Button::widget( array('buttonType' => 'submit', 'label' => 'Отправить')); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- search-form -->