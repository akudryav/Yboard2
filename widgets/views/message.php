<?php

use yii\helpers\Url;
use yii\bootstrap4\Modal;

Modal::begin([
    'id' => 'mesModal',
    'title' => 'Чат с продавцом',
    'toggleButton' => [
        'id' => 'js_message',
        'label' => 'Написать',
        'class' => 'btn btn-primary',
        'data-url' => Url::to(['/lk/messages/dialog', 'chat_id' => $chat_id]),
    ],
]);
?>
<div id="chat" class="chat">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<?php
Modal::end();

$script = <<< JS
$('#js_message').on('click', function(e){
  e.preventDefault();
  $('#mesModal').find('#chat').load($(this).data('url'));
});
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>