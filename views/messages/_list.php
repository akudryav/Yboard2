<?php
/* @var $this MessagesController */
/* @var $data Messages */

use yii\helpers\Url;
use yii\bootstrap4\Html;

?>

<div class="view mes_list">


    <i class='mesDate' style='float:right; font-size:12px; '>
        <?php echo Yii::$app->formatter->asDatetime($data['last_date']); ?>
    </i>

    <a href='<?php echo Url::to('messages/dialog', array('user' => $data['interlocutor'])); ?>'>
        <b><?php echo Html::encode($data['username']); ?></b> </a>
    <br/>
    Сообщений (<?php echo Html::encode($data['count_mes']); ?>)

</div>