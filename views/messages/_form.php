<?php
/* @var $this MessagesController */
/* @var $model Messages */
/* @var $form CActiveForm */

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

?>

<div class="form">

    <?php
    $form = ActiveForm::begin(array(
        'id' => 'messages-form',
        'enableAjaxValidation' => false,
        'action' => Url::to(['messages/create', 'id' => $receiver])
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>


    <?php echo $form->field($model, 'message')->textarea(); ?>


    <div class="row buttons">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Send') : Yii::t('app', 'Save'), array('class' => 'btn btn-light')); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->