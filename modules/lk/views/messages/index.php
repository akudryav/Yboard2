<?php
/* @var $this MessagesController */

/* @var $dataProvider ActiveDataProvider */

use yii\bootstrap4\Html;
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
                    <div id="plist" class="people-list">
                        <ul class="list-unstyled chat-list mt-2 mb-0">
                        <?php foreach($chats as $chat):
                            $chat_image = $chat->advert->getImage();
                            $chat_name = $chat->advert->name;
                            ?>
                            <li class="clearfix" data-chat="<?=$chat->chat_id?>">
                                <?php echo Html::img($chat_image->getUrl('45x45'), ['class' => 'card-img-top', 'alt' => $chat_name]); ?>
                                <div class="about">
                                    <div class="name"><?=$chat_name?></div>
                                </div>
                            </li>
                            <?php endforeach;?>

                        </ul>
                    </div>
                    <div id="chat" class="chat">

                    </div>
                </div>
            </div>
        </div>

<?php

/*
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'advert',
            'value' => 'advert.name'
        ],
        [
            'attribute' => 'message',
            'format' => 'text'
        ],
        'read:boolean',
        'created_at:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
        ]
    ]
]);*/


