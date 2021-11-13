<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/* @var $this AdvertsController */
/* @var $model Adverts */

$image = $model->getImage();
?>

<div class="card border-secondary mb-3">
    <a href="<?= Url::to(['adverts/view', 'id' => $model->id]) ?>" class="text-decoration-none">
        <?php echo Html::img($image->getUrl('x220'), ['class' => 'card-img-top', 'alt' => $model->name]); ?>
        <div class="card-body">
            <p class="card-subtitle mb-2 text-muted"><?= $model->price ?><span>₽</span></p>
            <h5 class="card-title text-dark"><?php echo Html::encode($model->name); ?></h5>
        </div>
    </a>
    <div class="card-footer text-muted">
        <i class="fa fa-eye"></i><?= $model->views ?>
        <a href="javascript:void(0)" title="В избранное"
           onclick="setFavoriteAdv(<?= $model->id ?>, this)">
            <i class="fa fa-bookmark-o"></i></a>
    </div>
</div>

