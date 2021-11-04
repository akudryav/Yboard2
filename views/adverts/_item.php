<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/* @var $this AdvertsController */
/* @var $model Adverts */

$image = $model->getImage();
?>

<div class="card border-secondary mb-3">
    <?php echo Html::img($image->getUrl('350x'), ['class' => 'card-img-top', 'alt' => $model->name]); ?>
    <div class="card-body">
        <h5 class="card-title"><?php echo Html::encode($model->name); ?></h5>
        <p class="card-text"><?php echo StringHelper::truncate($model->text, 150); ?></p>
        <?php echo Html::a(Yii::t('adv', 'Details'),
            ['adverts/view', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a(Yii::t('adv', 'Message'),
            '#', ['class' => 'card-link']); ?>
    </div>
</div>

