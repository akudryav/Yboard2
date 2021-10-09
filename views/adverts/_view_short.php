<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\helpers\Url;

// dump( $model );

//$model = $model->gallery->galleryPhotos[0];


?>

<a href="<?= Url::to('@web/adverts/view', array('id' => $model->id))
?>" class="fancybox" rel="<?php echo Html::encode($model->id) ?>">
   <?php if ( $model->getPhoto() ) { ?>
        <img src="<?php echo $model->getPhoto(); ?>" <
             style='max-width:95px; max-height:60px;' alt="<?php echo Html::encode($data->name) ?>" />

    <?php } ?>
    <?= $model->name ?>
</a>