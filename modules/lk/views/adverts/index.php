<?php

use yii\grid\GridView;
use yii\bootstrap4\Html;

?>


    <h1><?php echo Yii::t('adv', 'Manage adverts'); ?></h1>
    <p>
        <?= Html::a(Yii::t('adv', 'Create advert'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        'views',
        'created_at:datetime',
        [
            'attribute' => 'moderated',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->statusName();
            }
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);