<?php
use yii\bootstrap4\Modal;
$profile = $model->profile;

Modal::begin([
    'id' => 'profileModal',
    'title' => $profile->getName(),
    'toggleButton' => [
        'label' => 'Показать номер',
        'class' => 'btn btn-primary',
    ],
]);
?>
    <div class="row">
        <div class="col-md-4"><?php echo $model->getAvatar(); ?></div>
        <div class="col-md-4">
            <p><?=$profile->city?></p>
            <p>С <?= Yii::$app->formatter->asDate($model->created_at) ?></p>
        </div>
    </div>
        <hr>
    <div class="text-justify">
        <h3><?=$profile->phone?></h3>
        <?php
            echo \app\widgets\Favorites::widget(['type' => 'button', 'model' => $advert]);
        ?>
    </div>


<?php
Modal::end();