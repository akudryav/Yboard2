<?php

use app\assets\ChatAsset;
use yii\widgets\ListView;
use yii\bootstrap4\Html;
use app\widgets\Message;
use yii\widgets\DetailView;

/* @var $this SiteController */
/* @var $model Bulletin */

$this->context->title = $model->name;
ChatAsset::register($this);
$params = $model->paramsArray();
?>
<script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
    <div class="jumbotron">
        <h1><?= $model->name ?></h1>
        <div class="image">
            <?php
            echo newerton\fancybox3\FancyBox::widget();
            foreach ($model->getImages() as $img) {
                echo Html::a(Html::img($img->getUrl('350x')), $img->getUrl(), ['data-fancybox' => 'group1']);
            }
            ?>
        </div>
        <?php
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'text:html',    // description nl2br($model->text);
                [
                    'attribute' => 'price',
                    'value' => $model->price ?: Yii::t('adv', 'Not set'),
                ],
                [                      // the owner name of the model
                    'attribute' => 'category_id',
                    'value' => $model->category->name,
                ],
                'created_at:datetime', // creation date formatted as datetime
            ],
        ]);
        ?>
        <?php if (!empty($params)): ?>
            <table class="table table-striped table-bordered">
                <?php foreach ($params as $f_name => $f_value) {
                    echo "<tr><th>$f_name</th><td>$f_value</td></tr>";
                }
                ?>
            </table>
        <?php endif ?>
        <?php if ($model->user_id != Yii::$app->user->id) {
            echo Message::widget(['advert' => $model]);
        }
        ?>
        <div class="row info">
            <div class="col">
                <i class="fa fa-eye"></i><?= $model->views ?>
                <a href="javascript:void(0)" title="В избранное"
                   onclick="setFavoriteAdv(<?= $model->id ?>, this)">
                    <i class="fa fa-bookmark-o"></i></a>
        </div>
        <div class="col">
            <div class="float-right yashare-auto-init" data-yashareL10n="ru" data-yashareType="link"
                 data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir"></div>
        </div>
    </div>
</div>
    <h3><?= Yii::t('adv', 'Related adverts') ?></h3>
<?php echo ListView::widget([
    'dataProvider' => $dataRel,
    'options' => ['class' => 'card-columns'],
    'summary' => '',
    'itemOptions' => [
        'tag' => false,
    ],
    'itemView' => '_item',
    'summary' => false,
]);
?>