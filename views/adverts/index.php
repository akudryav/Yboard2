<?php

/* @var $this SiteController */

use yii\widgets\ListView;

$this->context->title = Yii::$app->name;

if (!$data) {
    echo "<div class='results'>" . Yii::t('app', "No results for full search. Show simplified search results:") . "</div>";
}
?>

    <?php echo $this->render('/adverts/_list', ['dataProvider' => $data]); ?>



