<?php
/* @var $this CategoryController */
/* @var $model Category */


use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    ['label' => Yii::t('app', 'Categories'), 'url' => array('index')],
    ['label' => $model->name, 'url' => array('view', 'id' => $model->id)],
    Yii::t('app', 'Update'),
);

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('app', 'List Category'), 'icon' => 'icon-list', 'url' => array('index')),
        array('label' => Yii::t('app', 'Create Category'), 'icon' => 'icon-plus', 'url' => array('create')),
        array('label' => Yii::t('app', 'View Category'), 'icon' => ' icon-eye-open', 'url' => array('view', 'id' => $model->id)),
        array('label' => Yii::t('app', 'Manage Category'), 'icon' => 'icon-folder-open', 'url' => array('view')),
        array('label' => Yii::t('app', 'Удалить категорию'), 'icon' => 'icon-folder-open', 'url' => array('/view/category/delete', 'id' => $model->id)),
    )
]);
?>

    <h1><?php echo Yii::t('app', 'Update Category'); ?><?php echo $model->id; ?></h1>

<?php echo $this->render('_form', array('model' => $model)); ?>