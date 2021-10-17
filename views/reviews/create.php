<?php
/* @var $this ReviewsController */
/* @var $model Reviews */


use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    ['label' => 'Reviews', 'url' => array('index')],
    'Create',
);

echo Menu::widget([
    'items' =>array(
    array('label' => 'List Reviews', 'url' => array('index')),
    array('label' => 'Manage Reviews', 'url' => array('view')),
)
]);
?>

<h1>Create Reviews</h1>

<?php echo $this->render('_form', array('model' => $model)); ?>