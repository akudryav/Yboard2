<?php

/* @var $this SiteController */

use yii\widgets\ListView;

$this->context->title = Yii::$app->name;

if (!$data) {
    echo "<div class='results'>" . Yii::t('app', "No results for full search. Show simplified search results:") . "</div>";
}

echo ListView::widget( array(
    'dataProvider' => $data,
    'itemView' => '_view_short',
));


