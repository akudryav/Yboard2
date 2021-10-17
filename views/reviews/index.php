<?php
/* @var $this ReviewsController */
/* @var $dataProvider ActiveDataProvider */

use yii\widgets\ListView;

use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    'Reviews',
);

echo Menu::widget([
    'items' => array(
        array('label' => 'Create Reviews', 'url' => array('create')),
        array('label' => 'Manage Reviews', 'url' => array('view')),
    )
]);
?>

<h1>Reviews</h1>

<?php
echo ListView::widget( array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>


<?php ?>

