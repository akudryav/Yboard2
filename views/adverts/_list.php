<?php
use yii\widgets\ListView;

echo ListView::widget(array(
    'dataProvider' => $dataProvider,
    'options' => ['class' => 'card-columns'],
    'summary' => '',
    'itemOptions' => [
        'tag' => false,
    ],
    'itemView' => '_item',
    'summary' => false,
));
?>