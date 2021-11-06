<?php
/* @var $this MessagesController */

/* @var $dataProvider ActiveDataProvider */

use yii\grid\GridView;

$this->params['breadcrumbs'] = array(
    Yii::t('message', 'Messages'),
);

?>

    <h2><?= Yii::t('message', 'Messages') ?></h2>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'advert',
            'value' => 'advert.name'
        ],
        [
            'attribute' => 'message',
            'format' => 'text'
        ],
        'read:boolean',
        'created_at:datetime',
    ]
]);


