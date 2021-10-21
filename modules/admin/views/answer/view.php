<?php
/* @var $this AnswerController */
/* @var $model Answer */


use yii\grid\GridView;
use yii\widgets\Menu;
use yii\widgets\DetailView;

$this->params['breadcrumbs'] = array(
    Yii::t('app', 'Answers') => array('index'),
    $model->id,
);

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('app', 'List Answer'), 'icon' => 'icon-list', 'url' => array('index')),
        array('label' => Yii::t('app', 'Create Answer'), 'icon' => 'icon-plus', 'url' => array('create')),
        array('label' => Yii::t('app', 'Update Answer'), 'icon' => 'icon-refresh', 'url' => array('update', 'id' => $model->id)),
        array('label' => Yii::t('app', 'Delete Answer'), 'icon' => 'icon-minus', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
        array('label' => Yii::t('app', 'Manage Answer'), 'icon' => 'icon-folder-open', 'url' => array('view')),
    )
]);
?>

<h1><?php echo Yii::t('app', 'View Answer'); ?> #<?php echo $model->id; ?></h1>

<?php
echo DetailView::widget(
    array(
        'model' => $model,
        'attributes' => array(
            'id',
            'parent_id',
            'user_id',
            'text',
            'created_at',
            'updated_at',
        ),
    )
);
?>
