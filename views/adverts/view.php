<?php

use app\assets\ChatAsset;
use yii\widgets\DetailView;
use yii\bootstrap4\Html;
use app\widgets\Message;
use app\widgets\Favorites;

/* @var $this SiteController */
/* @var $model Bulletin */

$this->context->title = $model->name;
ChatAsset::register($this);
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
        'value' => Message::widget(['advert' => $model]),
        'visible' => $model->user_id != Yii::$app->user->id,
    ],
    [
        'label' => 'В избранном',
        'format' => 'raw',
        'value' => $model->favoriteCount.' '.Favorites::widget(['type' => 'button', 'model' => $model]),
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
    <h1><?= $model->name ?></h1>
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

<h3><?= Yii::t('adv', 'Other Seller Ads') ?></h3>
<?php echo $this->render('_list', ['dataProvider' => $dataRel]); ?>