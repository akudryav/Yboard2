<?php
/* @var $this CategoryController */
/* @var $model Category */


use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    ['label' => Yii::t('app', 'Categories'), 'url' => array('index')],
    Yii::t('app', 'Create'),
);

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('app', 'List Category'), 'icon' => 'icon-list', 'url' => array('index')),
        array('label' => Yii::t('app', 'Manage Category'), 'icon' => 'icon-folder-open', 'url' => array('view')),
    )
]);
?>

    <h1><?php echo Yii::t('app', 'Create Category'); ?></h1>

<?php echo $this->render('_form', array('model' => $model)); ?>