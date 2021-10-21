<?php
/* @var $this BulletinController */

/* @var $model Bulletin */


use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    Yii::t('app', 'Bulletins') => array('index'),
    Yii::t('app', 'Create'),
);

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('app', 'List Bulletin'), 'icon' => 'icon-list', 'url' => array('index')),
        array('label' => Yii::t('app', 'Manage Bulletin'), 'icon' => 'icon-folder-open', 'url' => array('view')),
    )
]);
?>

    <h1><?php echo Yii::t('app', 'Create Bulletin'); ?></h1>

<?php echo $this->render('_form', array('model' => $model)); ?>