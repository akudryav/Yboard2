<?php
/* @var $this AnswerController */
/* @var $model Answer */


use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    ['label' => Yii::t('app', 'Answers'), 'url' => array('index'),],
    Yii::t('app', 'Create'),
);

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('adv', 'List Answer'), 'icon' => 'icon-list', 'url' => array('index')),
        array('label' => Yii::t('adv', 'Manage Answer'), 'icon' => 'icon-folder-open', 'url' => array('view')),
    )
]);
?>

    <h1><?php echo Yii::t('adv', 'Create Answer'); ?></h1>

<?php echo $this->render('_form', array('model' => $model)); ?>