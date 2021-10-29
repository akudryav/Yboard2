<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Adverts */

$this->title = Yii::t('app', 'Update advert: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Yours adverts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="adv-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>