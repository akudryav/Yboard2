<?php
/* @var $this ReviewsController */
/* @var $model Reviews */

$this->params['breadcrumbs'] = array(
    Yii::t('app', 'Profile') => array('user', array("id" => $model->id)),
    Yii::t('app', 'Update'),
);
?>

    <h1> <?= Yii::t('app', 'Profile update') ?> </h1>

<?php echo $this->render('_form', array('model' => $model)); ?>