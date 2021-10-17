<?php
/* @var $this MessagesController */
/* @var $dataProvider ActiveDataProvider */

use yii\widgets\ListView;
use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    'Messages',
);

echo Menu::widget([
    'items' => array(
        array('label' => 'Create Messages', 'url' => array('create')),
        array('label' => 'Manage Messages', 'url' => array('view')),
    )
]);
?>

<h1>Messages</h1>

<?php
echo ListView::widget( array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>


<?php ?>

