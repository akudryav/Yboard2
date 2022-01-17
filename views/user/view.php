<?php

$profile = $model->profile;

?>
<div class="row">
    <div class="col-md-4"><?php echo $model->getAvatar(); ?></div>
    <?php echo \app\widgets\Rating::widget(['profile' => $profile]);?>
    <div class="col-md-4">
        <p><?php echo $profile->getName() . ', ' . $profile->city ?></p>
        <p>На площадке с <?= Yii::$app->formatter->asDate($model->created_at) ?></p>
    </div>
</div>
<h3>Объявления</h3>
<?php echo $this->render('/adverts/_list', ['dataProvider' => $dataProvider]); ?>
