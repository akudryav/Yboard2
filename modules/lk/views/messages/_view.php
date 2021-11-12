<?php
/* @var $this MessagesController */

/* @var $data Messages */

use yii\bootstrap4\Html;

?>

<div class="view mes_dialog">

    <b> <?php echo Html::encode($data->author->username); ?></b>
    <i class='mesDate' style='font-size:10px; '>
        (<?php echo Yii::$app->formatter->asDatetime($data->created_at); ?>)
    </i> :
    <br/>
    <?php echo $data->message; ?>

</div>