<?php

use yii\bootstrap4\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Adverts */

$this->title = Yii::t('adv', 'Create advert');

?>
<div class="ads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $root_categ->makeChildList(),
    ]) ?>

</div>