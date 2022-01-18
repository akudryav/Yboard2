<?php
use yii\widgets\ListView;

echo ListView::widget(array(
    'dataProvider' => $dataProvider,
    'options' => ['class' => 'row product-list'],
    'summary' => false,
    'summaryOptions' => ['tag' => false],
    'itemOptions' => ['class' => 'col-6 col-md-4 col-lg-3 product-list__item'],
    'itemView' => '_item',
));
?>