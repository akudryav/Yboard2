<?php

use yii\bootstrap4\Html;
use app\widgets\Filter;

/* @var $this SiteController */
/* @var $model Category */

$this->context->title = Yii::$app->name;

?>

<h3>Категория "<?= Html::encode($model->name) ?>"</h3>
<?php echo Filter::widget(['cat' => $model]);?>
<?php echo $this->render('_list', ['dataProvider'=>$dataProvider]);?>

