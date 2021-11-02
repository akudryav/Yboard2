<?php
/* @var $this BulletinController */
/* @var $model Bulletin */

/* @var $form CActiveForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap4\Button;


?>

<div class="wide form">

    <?php
    $form = ActiveForm::begin(array(
        'action' => Url::to($this->context->route),
        'method' => 'get',
        'options' => array('class' => 'well'),
    ));
    ?>

    <div class="row">
        <?php echo $form->field($model, 'id')->textInput(); ?>
    </div>

    <div class="row">
        <?php echo $form->field($model, 'name')->textInput(); ?>
    </div>

    <div class="row">
        <?php echo $form->field($model, 'user_id')->textInput(); ?>
    </div>

    <div class="row">
        <?php echo $form->field($model, 'category_id')->textInput(); ?>
    </div>

    <div class="row">
        <?php echo $form->field($model, 'type')->checkbox(); ?>
    </div>

    <div class="row">
        <?php echo $form->field($model, 'views')->textInput(); ?>
    </div>

    <div class="row">
        <?php echo $form->field($model, 'text')->textarea(); ?>
    </div>

    <div class="row buttons">
        <?php echo Button::widget(['options' => array('type' => 'submit', 'label' => 'Отправить')]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- search-form -->