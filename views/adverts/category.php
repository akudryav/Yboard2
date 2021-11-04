<?php

use yii\bootstrap4\Html;
use yii\widgets\ListView;

/* @var $this SiteController */
/* @var $model Category */

$this->context->pageTitle = Yii::$app->name;

?>

<h3>Категория "<?= Html::encode($model->name) ?>"</h3>
<div class="card-columns">
    <?php echo ListView::widget(array(
        'dataProvider' => $dataProvider,
        'itemOptions' => [
            'tag' => false,
        ],
        'itemView' => '_item',
    ));
    ?>
</div>

