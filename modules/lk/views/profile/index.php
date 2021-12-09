<?php
/* @var $this MessagesController */
/* @var $model Messages */

use yii\widgets\DetailView;
use yii\bootstrap4\Html;

?>

<h1><?= Yii::t('user', 'Profile') ?></h1>
<p>
<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</p>
<?php
echo DetailView::widget( array(
    'model' => $model,
    'attributes' => array(
        'first_name',
        'last_name',
        'city',
        'phone',
        'company',
        'birthdate:date',
    ),
));
?>
