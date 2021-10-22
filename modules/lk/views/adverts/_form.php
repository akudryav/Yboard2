<?php

/* @var $categories array */

use yii\widgets\ActiveForm;

?>

<div class="form well">

    <?php
    $form = ActiveForm::begin(array(
        'id' => 'bulletin-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->field($model, 'name'); ?>

    <div class="row">
        <?php $this->widget('application.widgets.BulletinCategoryWidget', array('model' => $model, 'form' => $form)); ?>
    </div>
    <?= $form->field($model, 'text')->textarea(['rows' => '6']) ?>
    <?php echo $form->field($model, 'price'); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->