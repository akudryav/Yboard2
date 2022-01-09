<?php

use app\assets\UserAsset;

UserAsset::register($this);

$profile = $model->profile;
$chats = $profile->isRateble();
if ($chats) {
    $script = <<< JS
$('.star').rater({ postHref: '/user/rating' });
JS;
    $this->registerJs($script, \yii\web\View::POS_READY);
}

?>
<div class="row">
    <div class="col-md-4"><?php echo $model->getAvatar(); ?></div>
    <div class="col-md-4 star" id="<?php echo $model->id; ?>">
	<span class="rater">
	<span class="rater-starsOff" style="width:160px;"><span class="rater-starsOn"></span></span>
        <span class="test-text">
        <span class="rater-rating"><?php echo $profile->rating_avg ?></span>&#160;
        (голосов <span class="rater-rateCount"><?php echo $profile->rating_count ?></span>)
        </span>
    </span>
    </div>
    <div class="col-md-4">
        <p><?php echo $profile->getName() . ', ' . $profile->city ?></p>
        <p>На площадке с <?= Yii::$app->formatter->asDate($model->created_at) ?></p>
    </div>
</div>
<h3>Объявления</h3>
<?php echo $this->render('/adverts/_list', ['dataProvider' => $dataProvider]); ?>
