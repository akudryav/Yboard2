<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Adverts */

$this->title = Yii::t('adv', 'Update advert: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('adv', 'My adverts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="adv-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'root_categories' => $root_categories,
    ]) ?>

</div>