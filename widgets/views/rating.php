<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

if ($chats) {

Modal::begin([
    'id' => 'rateModal',
    'title' => 'Выберите объявление',
]);
?>
<div id="rating">
    <?php
        echo $this->render('/reviews/_plist', ['chats' => $chats]);
        $form = ActiveForm::begin([
            'id' => 'rating-form',
            'action' => '/reviews/rating',
            'options' => [
                'class' => 'hidden'
             ],
        ]);
        echo $form->field($model, 'advert_id')->hiddenInput()->label(false);
        echo $form->field($model, 'rating')->dropDownList(
            array_combine(range(1, 5), range(1, 5)));
        echo $form->field($model, 'message')->textarea();
        echo Html::submitButton(Yii::t('app', 'Оценить'), ['class' => 'btn btn-primary']);
        ActiveForm::end();
    ?>
    <div id="feedback" class="invalid-feedback"></div>
</div>

<?php
Modal::end();

}
?>

<div class="col-md-4" id="star">
	<span class="rater">
	<span class="rater-starsOff" style="width:160px;">
        <span class="rater-starsOn" style="width:<?=$profile->rating_avg*160/5?>px"></span>
    </span>
        <span class="test-text">
        <span class="rater-rating"><?php echo $profile->rating_avg ?></span>&#160;
        (голосов <span class="rater-rateCount"><?php echo $profile->rating_count ?></span>)
        </span>
    </span>
</div>
