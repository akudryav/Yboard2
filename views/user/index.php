<?php


use yii\grid\GridView;
use yii\widgets\Menu;
use yii\helpers\Html;

$this->params['breadcrumbs'] = array(
    Yii::t('app', "Users"),
);
if (Yii::$app->user->isAdmin()) {
    echo Menu::widget([
        'items' => array(
            array('label' => Yii::t('app', 'Manage Users'), 'icon' => 'icon-folder-open', 'url' => array('/user/view')),
            array('label' => Yii::t('app', 'Manage Profile Field'), 'icon' => 'icon-list-alt', 'url' => array('profileField/view')),
        )
    ]);
}
?>

<h1><?php echo Yii::t('app', "List User"); ?></h1>

<?php
echo GridView::widget(array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'attribute' => 'username',
            'format' => 'raw',
            'content' => function ($data) {
                return Html::a(Html::encode($data->username), array("user/view", "id" => $data->id));
            } ,
        ),
        'create_at',
        'lastvisit_at',
    ),
));
?>
