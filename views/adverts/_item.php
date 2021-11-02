<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/* @var $this AdvertsController */
/* @var $model Adverts */

$image = $model->getImage();
?>

<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <?= Html::img($image->getPath('350x'), ['alt' => $model['name']]) ?>
        <div class="caption">
            <h3><?php echo Html::encode($model['name']); ?></h3>
            <p><?php echo StringHelper::truncate($model['text'], 150); ?></p>
            <p><a href="<?= Url::to(['adverts/view', 'id' => $model['id']]) ?>" class="btn btn-primary" role="button">Подробнее</a>
                <a href="#" class="btn btn-default" role="button">Написать</a></p>
        </div>
    </div>
</div>
