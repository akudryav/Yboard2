<?php
/* @var $this FavoritesController */
/* @var $dataProvider ActiveDataProvider */

use yii\widgets\ListView;
use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    'Favorites',
);

echo Menu::widget([
    'items' => array(
        array('label' => 'Create Favorites', 'url' => array('create')),
        array('label' => 'Manage Favorites', 'url' => array('view')),
    )
]);
?>

<h1>Favorites</h1>

<?php
echo ListView::widget( array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>


<?php ?>

