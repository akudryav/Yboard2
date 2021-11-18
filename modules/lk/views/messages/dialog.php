    <div class="chat-history">
        <ul class="m-b-0">
            <?php foreach($messages as $mes):?>
            <li class="clearfix">
                <div class="message-data <?php if($mes->author->id != $userData->id) echo 'text-right';?>">
                    <span class="message-data-time"><?= Yii::$app->formatter->asDateTime($mes->created_at) ?></span>
                    <?php echo $mes->author->getAvatar(); ?>
                </div>
                <div class="message other-message float-right"><?= $mes->message?></div>
            </li>
            <?php endforeach;?>
        </ul>
    </div>

<?php echo $this->render('_form', ['model' => $model]); ?>