<?php
use yii\widgets\ListView;

echo ListView::widget(array(
    'dataProvider' => $dataProvider,
    'options' => ['class' => 'row row-cols-1 row-cols-md-4 g-4'],
    'summary' => false,
    'summaryOptions' => ['tag' => false],
    'itemOptions' => ['class' => 'col'],
    'itemView' => '_item',
));
?>