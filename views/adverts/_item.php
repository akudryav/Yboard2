<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $this AdvertsController */
/* @var $model Adverts */

$image = $model->getImage();
?>

<div class="product-item">
    <div class="product-item__header">
        <a href="<?= Url::to(['adverts/view', 'id' => $model->id]) ?>" class="product-item_image"
           style="background-image: url('<?=$image->getUrl('x220')?>');">
            <?php echo Html::img('/images/loader.svg', [
                    'data-src' => $image->getUrl('x220'),
                    'class' => 'product-item__img',
                    'alt' => $model->name,
                ]); ?>
        </a>
        <span class="product-item__location">
            <span class="product-item__location_item"><?= $model->city ?></span>
        </span>
    </div>
    <div class="product-item__content">
        <?php echo \app\widgets\Favorites::widget(['model' => $model]); ?>
        <a href="<?= Url::to(['adverts/view', 'id' => $model->id]) ?>" class="product-item__content_block">
                <span class="product-item__price">
                  <span class="product-item__price_value"><?= $model->price ?></span>
                  <span class="product-item__price_currency">₽</span>
                </span>
            <span class="product-item__title"><?php echo Html::encode($model->name); ?></span>
        </a>
    </div>
</div>

