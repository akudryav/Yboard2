<?php
/* @var $this MessagesController */

/* @var $dataProvider ActiveDataProvider */

use app\assets\ChatAsset;

$this->params['breadcrumbs'] = array(
    Yii::t('message', 'Messages'),
);
ChatAsset::register($this);
?>

    <h2><?= Yii::t('message', 'Messages') ?></h2>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <?php echo $this->render('//reviews/_plist', ['chats' => $chats]); ?>
                <div id="chat" class="chat">

                </div>
            </div>
        </div>
    </div>



