<?php


use yii\widgets\Menu;

$path = $model->getAdminBreadcrumbs(true);

$this->params['breadcrumbs'] = array_merge(array(
    'Cms' => array('index'),
), $path, array('View')
);

echo Menu::widget([
    'items' =>array(
        array('label' => Yii::t('app', 'Update') . " \"" . $model->name . "\"", 'url' => array('update', 'id' => $model->id)),
        array('label' => Yii::t('app', 'Delete'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?'), 'visible' => $model->id != 1),
        array('label' => Yii::t('app', 'Manage pages'), 'url' => array('view', 'parent_id' => $model->parent_id ? $model->parent_id : 1)),
    )
]);
?>

<h1><?php echo ucfirst($model->name) ?></h1>
<p><?php echo $model->pageType ?> </p>

<?php
echo $this->render('view/' . $this->getFormPartial($model), array('model' => $model));
?>

