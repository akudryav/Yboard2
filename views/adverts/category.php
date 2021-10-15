<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this SiteController */
/* @var $model Category */

$this->context->pageTitle = Yii::$app->name;

/*
echo Breadcrumbs::widget( array();
if ($model->parent)
    $this->breadcrumbs[$model->parent->name] = array('site/category', 'id' => $model->parent->id);
$this->breadcrumbs[] = Html::encode($model->name);
/**/
?>

<h3>Категория "<?= Html::encode($model->name) ?>"</h3>

<?php

    echo ListView::widget( array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
) );
?>

