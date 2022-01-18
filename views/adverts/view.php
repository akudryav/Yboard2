<?php

use app\assets\ChatAsset;
use yii\widgets\DetailView;
use yii\bootstrap4\Html;
use app\widgets\Favorites;

/* @var $this SiteController */
/* @var $model Bulletin */

$this->context->title = $model->name;
ChatAsset::register($this);
$user = $model->user;
$attributes = [
    'address',
    'text:text',
];
foreach ($model->paramsArray() as $f_name => $f_value) {
    $attributes[] = [
        'label' => $f_name,
        'value' => $f_value,
    ];
}
$attributes = array_merge($attributes, [
    'price',
    [
        'attribute' => 'category_id',
        'format' => 'html',
        'value' => $model->getCategoryLink(),
    ],
    [
        'label' => 'Узнайте больше',
        'format' => 'raw',
        'value' => Html::button('Показать номер', [
            'class' => 'btn btn-primary',
            'data-toggle' => 'modal',
            'data-target' => '#profileModal',
        ]).Html::button('Написать продавцу', [
                'class' => 'btn btn-secondary',
                'data-toggle' => 'modal',
                'data-target' => '#mesModal',
            ]),
        'visible' => $model->user_id != Yii::$app->user->id,
    ],
    [
        'label' => 'В избранном',
        'value' => $model->favoriteCount,
    ],
    [
        'label' => 'Просмотры',
        'value' => $model->views,
    ],
    'created_at:datetime',
    [
        'label' => 'Поделиться',
        'format' => 'raw',
        'value' => '<div class="ya-share2" data-services="vkontakte,twitter,facebook,odnoklassniki,moimir"></div>',
    ],
]);
?>
    <script src="https://yastatic.net/share2/share.js" async></script>
    <div class="container-wrapper">
        <div class="row content_page__row">
            <div class="col-12 col-lg-9 content_page__content">
                <div class="section-title">
                    <h1 class="section-title__value"><?= Html::encode($model->name) ?></h1>
                </div>
                <div class="clearfix">
                    <?php
                    echo newerton\fancybox3\FancyBox::widget();
                    foreach ($model->getImages() as $img) {
                        echo Html::a(Html::img($img->getUrl('200x'),
                            ['class' => 'rounded float-left']), $img->getUrl(), ['data-fancybox' => 'group1']);
                    }
                    ?>
                </div>
                <?php
                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes
                ]);
                ?>
            </div>

            <div class="col-12 col-lg-3 content_page__sidebar">
                <?php
                if($model->user_id != Yii::$app->user->id)
                {
                    echo '<div class="clearfix btn-group-vertical">';
                    echo \app\widgets\Profile::widget(['advert' => $model]);
                    echo \app\widgets\Message::widget(['advert' => $model]);
                    echo '</div>';
                }
                ?>
                <div class="row mt-3">
                    <div class="col-md-auto"><?php echo $user->getAvatar(); ?></div>
                    <div class="col-md-auto">
                        <p><?php echo $user->advertLink(); ?></p>
                        <p>С <?= Yii::$app->formatter->asDate($user->created_at) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row content_page__row">
            <div class="col-12 col-lg-12 content_page__content">
            <div class="section-title">
                <h3 class="section-title__value"><?= Yii::t('adv', 'Related adverts') ?></h3>
            </div>
            <?php echo $this->render('_list', ['dataProvider' => $dataRel]); ?>
            </div>
        </div>

    </div>
