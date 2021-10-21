<?php
/* @var $this BulletinController */

/* @var $model Bulletin */


use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    ['label' => Yii::t('app', 'Bulletins'), 'url' => array('index'),],
    ['label' => $model->name, 'url' => array('view', 'id' => $model->id),],
    Yii::t('app', 'Update'),
);

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('app', 'List Bulletin'), 'icon' => 'icon-list', 'url' => array('index')),
        array('label' => Yii::t('app', 'Create Bulletin'), 'icon' => 'icon-plus', 'url' => array('create')),
        array('label' => Yii::t('app', 'View Bulletin'), 'icon' => ' icon-eye-open', 'url' => array('view', 'id' => $model->id)),
        array('label' => Yii::t('app', 'Manage Bulletin'), 'icon' => 'icon-folder-open', 'url' => array('view')),
    )
]);
?>

    <h1><?php echo Yii::t('app', 'Update Bulletin'); ?><?php echo $model->id; ?></h1>

<?php echo $this->render('_form', array('model' => $model)); ?>