<?php
use yii\bootstrap4\Html;
?>
<div id="plist" class="col-6 people-list">
    <ul class="list-unstyled chat-list mt-2 mb-0">
        <?php foreach($chats as $chat):
            $chat_image = $chat->advert->getImage();
            $chat_name = $chat->advert->name;
            ?>
            <li class="clearfix" data-chat="<?=$chat->chat_id?>" data-advert="<?=$chat->advert_id?>">
                <?php echo Html::img($chat_image->getUrl('45x45'), ['class' => 'card-img-top', 'alt' => $chat_name]); ?>
                <div class="about">
                    <div class="name"><?=$chat_name?></div>
                </div>
            </li>
        <?php endforeach;?>

    </ul>
</div>