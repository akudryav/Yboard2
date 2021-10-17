<?php
/* @var $this MessagesController */
/* @var $model Messages */


use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    ['label' => 'Messages', 'url' => array('index')],
    'Create',
);

echo Menu::widget([
    'items' =>array(
    array('label' => 'List Messages', 'url' => array('index')),
    array('label' => 'Manage Messages', 'url' => array('view')),
)
]);
?>

<h1>Create Messages</h1>

<?php echo $this->render('_form', array('model' => $model)); ?>