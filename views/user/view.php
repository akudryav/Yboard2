<div class="row">
    <div class="col-md-4"><?php echo $model->getAvatar(); ?></div>
    <div class="col-md-4">
        <p><?php echo $model->profile->getName() . ', ' . $model->profile->city ?></p>
        <p>На площадке с <?= Yii::$app->formatter->asDate($model->created_at) ?></p>
    </div>
</div>
<h3>Объявления</h3>
<?php echo $this->render('/adverts/_list', ['dataProvider' => $dataProvider]); ?>
