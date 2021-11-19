    <div class="chat-history">
        <ul class="m-b-0">
            <?php foreach($messages as $mes):
                $data_class = ($mes->author->id != $userData->id) ? 'text-right' : '';
                $message_class = ($mes->author->id != $userData->id) ?
                    'other-message float-right' : 'my-message';
                ?>
            <li class="clearfix">
                <div class="message-data <?=$data_class?>">
                    <span class="message-data-time"><?= Yii::$app->formatter->asDateTime($mes->created_at) ?></span>
                    <?php echo $mes->author->getAvatar(); ?>
                </div>
                <div class="message <?=$message_class?>"><?= $mes->message?></div>
            </li>
            <?php endforeach;?>
        </ul>
    </div>

<?php echo $this->render('_form', ['model' => $model]); ?>