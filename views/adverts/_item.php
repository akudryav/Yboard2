<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $this AdvertsController */
/* @var $model Adverts */

$image = $model->getImage();
?>
<div class="card h-100">
    <div class="image">
        <a href="<?= Url::to(['adverts/view', 'id' => $model->id]) ?>" class="text-decoration-none">
            <?php echo Html::img($image->getUrl('x220'), ['class' => 'card-img-top', 'alt' => $model->name]); ?>
        </a>
        <p class="text-nowrap bg-light text-dark over-text">
            <?= $model->city ?>
        </p>
    </div>
    <div class="card-body">
        <p class="card-subtitle mb-2 text-muted"><?= $model->price ?><span>₽</span></p>
        <a href="<?= Url::to(['adverts/view', 'id' => $model->id]) ?>" class="text-decoration-none">
            <h5 class="card-title text-dark"><?php echo Html::encode($model->name); ?></h5>
        </a>
    </div>
    <div class="card-footer">
        <?php echo \app\widgets\Favorites::widget(['model' => $model]); ?>
    </div>
</div>
