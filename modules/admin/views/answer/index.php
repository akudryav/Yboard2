<?php
/* @var $this AnswerController */
/* @var $dataProvider ActiveDataProvider */


use yii\widgets\ListView;
use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    Yii::t('app', 'Answers'),
);

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('adv', 'Create Answer'), 'icon' => 'icon-plus', 'url' => array('create')),
        array('label' => Yii::t('adv', 'Manage Answer'), 'icon' => 'icon-folder-open', 'url' => array('view')),
    )
]);
?>

<h1><?php echo Yii::t('app', 'Answers'); ?></h1>

<?php
echo ListView::widget(array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
