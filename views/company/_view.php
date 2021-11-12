<?php
/* @var $this MessagesController */
/* @var $data Messages */
?>

<div class="view">

    <b><?php echo Html::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo Html::a(Html::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br />

    <b><?php echo Html::encode($data->getAttributeLabel('sender_id')); ?>:</b>
    <?php echo Html::encode($data->sender_id); ?>
    <br />

    <b><?php echo Html::encode($data->getAttributeLabel('receiver_id')); ?>:</b>
    <?php echo Html::encode($data->receiver_id); ?>
    <br />

    <b><?php echo Html::encode($data->getAttributeLabel('message')); ?>:</b>
    <?php echo Html::encode($data->message); ?>
    <br />

    <b><?php echo Html::encode($data->getAttributeLabel('created_at')); ?>:</b>
    <?php echo Html::encode($data->created_at); ?>
    <br />

    <b><?php echo Html::encode($data->getAttributeLabel('read_date')); ?>:</b>
    <?php echo Html::encode($data->read_date); ?>
    <br />


</div>