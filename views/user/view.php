<?php
use app\assets\UserAsset;
UserAsset::register($this);

$profile = $model->profile;

?>

    <div class="col-md-4"><?php echo $model->getAvatar(); ?></div>
    <?php echo \app\widgets\Rating::widget(['profile' => $profile]);?>
    <div class="col-md-4">
        <p><?php echo $profile->getName() . ', ' . $profile->city ?></p>
        <p>На площадке с <?= Yii::$app->formatter->asDate($model->created_at) ?></p>
    </div>


<div class="col-12 col-lg-12 content_page__content">
    <div class="section-title">
        <h3 class="section-title__value">Объявления</h3>
    </div>
<?php echo $this->render('/adverts/_list', ['dataProvider' => $dataProvider]); ?>
</div>
