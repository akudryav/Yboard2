<?php

use yii\helpers\Url;
use yii\bootstrap4\Modal;

Modal::begin([
    'id' => 'mesModal',
    'title' => 'Чат с продавцом',
    'toggleButton' => [
        'label' => 'Написать продавцу',
        'class' => 'btn btn-secondary',
    ],
]);
?>
<div id="chat" class="chat" data-url="<?=Url::to(['/lk/messages/dialog', 'chat_id' => $chat_id])?>">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<?php
Modal::end();

$script = <<< JS
$('#mesModal').on('show.bs.modal', function (e) {
    var chat = $(this).find('#chat');
    chat.load(chat.data('url'));
});
JS;
$this->registerJs($script, \yii\web\View::POS_READY);
?>