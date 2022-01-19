<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Adverts */

$this->title = Yii::t('adv', 'Update advert: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);

?>
<div class="adv-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>