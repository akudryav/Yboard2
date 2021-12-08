<?php
/* @var $this MessagesController */
/* @var $model Messages */

use yii\widgets\DetailView;

?>

<h1>Profile</h1>

<?php
echo DetailView::widget( array(
    'model' => $model,
    'attributes' => array(
        'first_name',
        'last_name',
        'country',
        'phone',
        'company',
        'birthdate:date',
    ),
));
?>
