<?php
/* @var $this MessagesController */
/* @var $model Messages */

use yii\widgets\DetailView;
use yii\widgets\Menu;


$this->params['breadcrumbs'] = array(
    'Messages' => array('index'),
    $model->id,
);

echo Menu::widget([
    'items' =>array(
    array('label' => 'List Messages', 'url' => array('index')),
    array('label' => 'Create Messages', 'url' => array('create')),
    array('label' => 'Update Messages', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Messages', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Messages', 'url' => array('view')),
)
]);
?>

<h1>View Messages #<?php echo $model->id; ?></h1>

<?php
echo DetailView::widget( array(
    'model' => $model,
    'attributes' => array(
        'id',
        'sender_id',
        'receiver_id',
        'message',
        'created_at',
        'read_date',
    ),
));
?>
