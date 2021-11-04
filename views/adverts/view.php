<?php

use yii\helpers\Url;
use yii\widgets\ListView;
use yii\bootstrap4\Html;

/* @var $this SiteController */
/* @var $model Bulletin */

$this->context->pageTitle = $model->name;

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
    <div class='price'><?= Yii::t('app', 'Price') ?> -
        <?php if ($model->price) { ?>
            <?= $model->price ?> ( ₽ )
        <?php } else {
            echo "<i>" . Yii::t('app', 'Not set') . "</i>";
        }
        ?>
    </div>
    <p><?php
        echo $this->render('/messages/_form', array(
                'model' => $mes_model,
                'receiver' => $model->user_id)
        );
        ?></p>
    <div class="info">
        <a href='<?php echo Url::to(['user/view', 'id' => $model->user_id]) ?>'>
            <i class='fa fa-user'></i><?= $model->username ?>
        </a>
        <i class='fa fa-clock-o'></i>
        <?= Yii::$app->formatter->asDateTime($model->created_at) ?>
        <i class='fa fa-eye'></i><?= $model->views ?>
        <div style='float:right; margin-top:-6px; '>
            <a href='javascript:void(0)' onclick='setFavoriteAdv("<?= $model->id ?>", this)'>
                <i class='fa fa-bookmark-o'></i></a>
            <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="link"
                 data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir"></div>
        </div>
    </div>

</div>
<h3><?= Yii::t('adv', 'Related adverts') ?></h3>
<div class="card-columns">
    <?php echo ListView::widget([
        'dataProvider' => $dataRel,
        'itemOptions' => [
            'tag' => false,
        ],
        'itemView' => '_item',
        'summary' => false,
    ]);
    ?>
</div>