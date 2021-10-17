<?php
/* @var $this MessagesController */
/* @var $dataProvider ActiveDataProvider */

use yii\widgets\ListView;

use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    Yii::t('app', 'Messages'),
);

echo Menu::widget([
    'items' => array(
        array('label' => 'Create Messages', 'url' => array('create')),
        array('label' => 'Manage Messages', 'url' => array('view')),
    )
]);

?>

    <h4><?= Yii::t('app', 'Messages') ?></h4>

<?php

echo ListView::widget(array(
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
));


