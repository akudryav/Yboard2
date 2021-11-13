<?php

use yii\bootstrap4\Html;
use yii\widgets\ListView;

/* @var $this SiteController */
/* @var $model Category */

$this->context->title = Yii::$app->name;

?>

<h3>Категория "<?= Html::encode($model->name) ?>"</h3>
<?php echo ListView::widget(array(
    'dataProvider' => $dataProvider,
    'options' => ['class' => 'card-deck'],
    'summary' => '',
    'itemOptions' => [
        'tag' => false,
    ],
    'itemView' => '_item',
));
?>

