<?php

use yii\helpers\Html;

?>

<h2>Error <?php echo $error->exception->statusCode; ?></h2>

<div class="error">
    <?php echo Html::encode($error->exception->getMessage()); ?>
</div>