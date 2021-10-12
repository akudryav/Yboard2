<?php
/* @var $this SiteController */
/* @var $model LoginForm */

/* @var $form CActiveForm */

use app\components\configer\Configer;

$this->context->pageTitle = Yii::$app->name . ' - Настройки';
echo Breadcrumbs::widget(array(
    'Настройки',
));
?>

<h1>Настройки</h1>

<?php
Configer::widget(array(
    'configPath' => $configPath
));
?>
