<?php

use app\assets\ChatAsset;
use yii\widgets\ListView;
use yii\bootstrap4\Html;
use app\widgets\Message;

/* @var $this SiteController */
/* @var $model Bulletin */

$this->context->title = $model->name;
ChatAsset::register($this);
$params = $model->paramsArray();
?>
    <script src="https://yastatic.net/share2/share.js" async></script>
        <h1><?= $model->name ?></h1>
        <div class="clearfix">
            <?php
            echo newerton\fancybox3\FancyBox::widget();
            foreach ($model->getImages() as $img) {
                echo Html::a(Html::img($img->getUrl('200x'),
                    ['class'=>'rounded float-left']), $img->getUrl(), ['data-fancybox' => 'group1']);
            }
            ?>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Описание</label>
            <div class="col-sm-10"><?php echo nl2br($model->text)?></div>
        </div>
        <?php if (!empty($params)): ?>
            <?php foreach ($params as $f_name => $f_value):?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><?=$f_name?></label>
                    <div class="col-sm-10"><?=$f_value?></div>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Цена</label>
            <div class="col-sm-10"><?php echo $model->price ?: Yii::t('adv', 'Not set')?></div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Категория</label>
            <div class="col-sm-10"><?php echo $model->getCategoryLink(); ?></div>
        </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Дата добавления</label>
        <div class="col-sm-10"><?php echo Yii::$app->formatter->asDatetime($model->created_at); ?></div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Поделиться</label>
        <div class="col-sm-10">
            <?php echo \app\widgets\Favorites::widget(['type' => 'button', 'model' => $model]); ?>
            <div class="ya-share2" data-services="vkontakte,twitter,facebook,odnoklassniki,moimir"></div>
        </div>
    </div>

<?php if ($model->user_id != Yii::$app->user->id) {
    echo Message::widget(['advert' => $model]);
}
?>

    <h3><?= Yii::t('adv', 'Related adverts') ?></h3>
    <?php echo $this->render('_list', ['dataProvider'=>$dataRel]);?>