<?php


use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    'Cms' => array('index'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('app', 'View') . " " . $model->name, 'url' => array('view', 'id' => $model->id)),
        array('label' => Yii::t('app', 'List pages'), 'url' => array('index')),
    )
]);
?>

    <h1><?= Yii::t('app', 'Update') ?><?php echo $model->name; ?></h1>

<?php echo $this->render('forms/' . $this->getFormPartial($model), array('model' => $model)); ?>