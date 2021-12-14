<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $this AdvertsController */
/* @var $model Adverts */

$image = $model->getImage();
?>

<div class="card border-secondary mb-3">
    <a href="<?= Url::to(['adverts/view', 'id' => $model->id]) ?>" class="text-decoration-none">
        <?php echo Html::img($image->getUrl('x220'), ['class' => 'card-img-top', 'alt' => $model->name]); ?>
        <div class="card-body">
            <p class="bg-transparent"><?= $model->city ?></p>
            <p class="card-subtitle mb-2 text-muted"><?= $model->price ?><span>₽</span></p>
            <h5 class="card-title text-dark"><?php echo Html::encode($model->name); ?></h5>
        </div>
    </a>
    <div class="card-footer text-muted">
        <?php echo \app\widgets\Favorites::widget(['model' => $model]); ?>
    </div>
</div>

