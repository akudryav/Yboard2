<?php
/* @var $this SiteController */
/* @var $model LoginForm */

/* @var $form CActiveForm */

use app\components\configer\Configer;

$this->context->title = Yii::$app->name . ' - Настройки';

?>

<h1>Настройки</h1>

<?php
Configer::widget(array(
    'configPath' => $configPath
));
?>
