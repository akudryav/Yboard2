<?php


use yii\widgets\Menu;

$this->breadcrumbs = array(
    'Cms' => array('view'),
    'Create',
);

echo Menu::widget([
    'items' => array(
    array('label' => 'Manage Cms', 'url' => array('view')),
)
]);
?>

<h1>Create <?php echo $model->getPageType($_GET['type']); ?></h1>

<?php echo $this->render('forms/' . $this->getFormPartial(), array('model' => $model)); ?>