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

    <?= $form->field($model, 'message')->textarea(['rows' => '3']) ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('message', 'Send'), ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->