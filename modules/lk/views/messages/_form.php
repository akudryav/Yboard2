<?php
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

$form = ActiveForm::begin(array(
    'id' => 'messages-form',
    'options' => [
       'class' => 'chat-message clearfix'
    ],
    'fieldConfig' => [
        'options' => [
            'tag' => false,
        ],
    ],
    'action' => Url::to(['/lk/messages/save']),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['/lk/messages/validate']),
));
?>
        <div class="input-group mb-0">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-send"></i></span>
            </div>
            <?php echo $form->field($model, 'message')->textInput([
                'tag' => false,
            ])->label(false);?>
        </div>

<?php
echo $form->field($model, 'receiver_id')->hiddenInput()->label(false);
echo $form->field($model, 'advert_id')->hiddenInput()->label(false);
echo $form->field($model, 'chat_id')->hiddenInput()->label(false);
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