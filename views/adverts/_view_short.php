<?php

use yii\helpers\Html;
use yii\helpers\Url;

// dump( $model );

//$model = $model->gallery->galleryPhotos[0];


?>

<a href="<?= Url::to(['adverts/view', 'id' => $model->id])
?>" class="fancybox" rel="<?php echo Html::encode($model->id) ?>">
    <?php if ($model->getPhoto()) { ?>
        <img src="<?php echo $model->getPhoto(); ?>" <
        style='max-width:95px; max-height:60px;' alt="<?php echo Html::encode($data->name) ?>" />

    <?php } ?>
    <?= $model->name ?>
</a>