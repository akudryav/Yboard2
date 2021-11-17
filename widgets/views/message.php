<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;

Modal::begin([
    'title' => 'Чат с продавцом',
    'toggleButton' => ['label' => 'Написать', 'class' => 'btn btn-primary'],
]);

$form = ActiveForm::begin(array(
    'id' => 'messages-form',
    'action' => Url::to(['/lk/messages/save']),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['/lk/messages/validate']),
));
echo $form->field($model, 'message')->textarea(['rows' => '3']);
echo $form->field($model, 'receiver_id')->hiddenInput()->label(false);
echo $form->field($model, 'advert_id')->hiddenInput()->label(false);
echo $form->field($model, 'chat_id')->hiddenInput()->label(false);
echo Html::submitButton(Yii::t('message', 'Send'), ['class' => 'btn btn-primary mb-2']);
ActiveForm::end();
?>
    <div id="error_alert" class="alert alert-danger alert-dismissible fade" role="alert">
        Ошибка при отправке сообщения
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div id="success_alert" class="alert alert-success alert-dismissible fade" role="alert">
        Сообщение успешно отправлено
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
Modal::end();

$script = <<< JS
$(document).on("beforeSubmit", "#messages-form", function () {
            var form = $(this);
            // return false if form still have some validation errors
            if (form.find('.has-error').length) {
                return false;
            }
            // submit form
            $.ajax({
            url    : form.attr('action'),
            type   : 'post',
            data   : form.serialize(),
            success: function (response) {
                if(response.success) {
                    $("#success_alert").addClass("show");
                    $("#messages-message").val('');
                } else {
                    $("#error_alert").addClass("show");
                }
            },
            error  : function () {
                console.log('internal server error');
            }
            });
            return false;
         });
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>