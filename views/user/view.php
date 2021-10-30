<?php

use yii\widgets\Menu;


echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('app', 'List User'), 'icon' => 'icon-list', 'url' => array('index')),
    )
]);
?>

<?php
// For all users
$attributes = array(
    'username',
    'full_name',
    'email',
    'birthday',
    'location',
    'phone',
    'skype',
    'contacts',
    'lastvisit_at',
    'create_at',
        //'value' => (($model->lastvisit_at != '0000-00-00 00:00:00') ? $model->lastvisit_at : t('Not visited')),
);

/*
  array_push($attributes, 'create_at', array(

  )
  );
 * 
 */
?>
<div class='userHead'>
    <h4><?php echo $model->username; ?></h4> <?php     if ($model->lastvisit_at) {
        echo "(" . Yii::$app->formatter->asDatetime($model->lastvisit_at) . ")";
    }
    ?>
    <?php if (Yii::$app->user->id == Yii::$app->request->getParam("id")) { ?>
        <a href='<?php echo Url::to('user/update', array('id' => $model->id)) ?>'> Редактировать </a>
    <?php } ?>
    <?php if (Yii::$app->user->isAdmin() and Yii::$app->user->id != $model->id) { ?>
        <a href='<?php echo Url::to('user/ban', array('id' => $model->id)) ?>'> Заблокировать </a>
    <?php } ?>
    <div>
        <a href='<?php echo Url::to("adverts/user", array('id' => $model->id)) ?>'> <?= Yii::t('app', 'Adverts') ?> </a>
        |
        <a href='<?php echo Url::to("user/view", array('id' => $model->id)) ?>'> <?= Yii::t('app', 'Personal dates') ?> </a>
    </div>
</div>
<div>
    <dl>
        <?php if ($model->full_name) { ?>
            <dt><?= Yii::t('app', 'Полное имя') ?> :</dt>
            <dd> <?= $model->full_name ?> </dd>
        <?php }
        if ($model->birthday and $model->birthday !== "0000-00-00") { ?>
            <dt><?= Yii::t('app', 'Дата рождения') ?> :</dt>
            <dd> <?= Yii::$app->formatter->asDate($model->birthday) ?> </dd>
        <?php }
        if ($model->location) { ?>
            <dt><?= Yii::t('app', 'Место проживания') ?> :</dt>
            <dd> <?= $model->location ?> </dd>
        <?php } ?>
        <br/>
        <h4><?= Yii::t('app', 'Контакты') ?> : </h4>
        <?php if ($model->phone) { ?>
            <dt><?= Yii::t('app', 'Телефон') ?> :</dt>
            <dd> <?= $model->phone ?> </dd>
        <?php }
        if ($model->skype) { ?>
            <dt><?= Yii::t('app', 'Skype') ?> :</dt>
            <dd> <?= $model->skype ?> </dd>
        <?php }
        if ($model->email) { ?>
            <dt><?= Yii::t('app', 'Почта') ?> :</dt>
            <dd> <?= $model->email ?> </dd>
        <?php }
        if ($model->contacts) { ?>


            <dt><?= Yii::t('app', 'Другие контакты') ?> :</dt>
            <dd> <?= $model->contacts ?> </dd>
        <?php } if ($model->create_at) { ?>
            <dt><?= Yii::t('app', 'Дата регистрации') ?> :</dt>
            <dd> <?= Yii::$app->formatter->asDate($model->create_at) ?> </dd>
        <?php } ?>

    </dl>
    <?php     if (Yii::$app->user->id !== $model->id) {
        echo $this->render('/messages/_form', array('model' => $mes_model, 'receiver' => $model->id));
    }
    ?>
</div>
