<?php

use yii\helpers\Url;
use yii\widgets\ListView;
use yii\bootstrap4\Html;
use app\widgets\Message;

/* @var $this SiteController */
/* @var $model Bulletin */

$this->context->title = $model->name;

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
    <p><?php echo nl2br($model->text); ?></p>
    <div class='attributes'>
        <?php
        if (is_array($model->fields))
            foreach ($model->fields as $f_name => $field) {
                echo "<div>"
                    . Yii::$app->params['categories'][$model->category_id]
                    ['fields'][$f_name]['name'] . " - " . $field
                    . "</div>";
            }
        ?>
    </div>
    <p class='price'><?= Yii::t('adv', 'Price') ?> -
        <?php if ($model->price) { ?>
            <?= $model->price ?> ( ₽ )
        <?php } else {
            echo "<i>" . Yii::t('adv', 'Not set') . "</i>";
        }
        ?>
    </p>
    <?php if ($model->user_id != Yii::$app->user->id) {
        echo Message::widget(['advert' => $model]);
    }
    ?>
    <div class="row info">
        <div class="col">
            <i class="fa fa-clock-o"></i>
            <?= Yii::$app->formatter->asDateTime($model->created_at) ?>
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
    'options' => ['class' => 'card-deck'],
    'summary' => '',
    'itemOptions' => [
        'tag' => false,
    ],
    'itemView' => '_item',
    'summary' => false,
]);
?>