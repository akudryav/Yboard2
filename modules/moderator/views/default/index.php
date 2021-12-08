<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

Pjax::begin();
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions'=>function($model){
        if($model->moderated == 0){
            return ['class' => 'text-danger'];
        }
    },
    'columns' => [
        'id',
        [
            'label' => 'Изображения',
            'format' => 'html',
            'value' => function ($data) {
                $html = '';
                foreach ($data->getImages() as $img) {
                    $html .= Html::img($img->getUrl('x70'));
                }
                return $html;
            },
        ],
        'name',
        'text:text',
        'created_at:datetime',
        [
            'attribute' => 'moderated',
            'filter'=>\app\models\Adverts::statusList(),
            'value' => function ($model) {
                return $model->statusName();
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['style' => ['white-space' => 'nowrap']],
            'template' => '{view} {approve} {decline}',
            'buttons' => [
                'view' => function ($url, $model) {
                    $url = Url::to(['/adverts/view', 'id' => $model->id]);
                    return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:1.125em" 
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path fill="currentColor" d="M573 241C518 136 411 64 288 64S58 136 3 241a32 32 0 000 30c55 105 162 177 285 177s230-72 285-177a32 32 0 000-30zM288 400a144 144 0 11144-144 144 144 0 01-144 144zm0-240a95 95 0 00-25 4 48 48 0 01-67 67 96 96 0 1092-71z"></path></svg>',
                        $url, ['target' => '_blank', 'title' => 'view']);
                },
                'approve' => function ($url, $model) {
                    $url = Url::to(['default/moderate', 'id' => $model->id, 'res' => 1]);
                    return Html::a('<i class="fa fa-check"></i>', $url, [
                        'title'=>'Утвердить', 'data-method' => 'post', 'data-pjax' => '1'
                    ]);
                },
                'decline' => function ($url, $model) {
                    $url = Url::to(['default/moderate', 'id' => $model->id, 'res' => 0]);
                    return Html::a('<i class="fa fa-times"></i>', $url, [
                        'title'=>'Отказать', 'data-method' => 'post', 'data-pjax' => '1'
                    ]);
                },
            ],

        ],
    ]
]);
Pjax::end();