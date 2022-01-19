<?php
/* @var $this MessagesController */

/* @var $dataProvider ActiveDataProvider */

use app\assets\ChatAsset;

ChatAsset::register($this);
?>
<div class="section-title">
    <h3 class="section-title__value"><?= Yii::t('message', 'Messages') ?></h3>
</div>

<div class="card chat-app">
    <?php echo $this->render('//reviews/_plist', ['chats' => $chats]); ?>
    <div id="chat" class="chat">

    </div>
</div>



