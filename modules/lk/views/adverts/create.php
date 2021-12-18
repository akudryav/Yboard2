<?php

use yii\bootstrap4\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Adverts */

$this->title = Yii::t('adv', 'Create advert');
$this->params['breadcrumbs'][] = ['label' => Yii::t('adv', 'My adverts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'root_categories' => $root_categories,
    ]) ?>

</div>