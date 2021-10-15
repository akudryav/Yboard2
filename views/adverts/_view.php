<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Adverts;

/* @var $this AdvertsController */
/* @var $model Adverts */



?>


<div class="well advertList">
    <div style='float:left; width: 95px; height: 60px; overflow:hidden;'>
            <a href="<?= Url::to(['adverts/view','id' => $model['id']])
            ?>" class="fancybox" rel="<?php echo Html::encode($model['id']) ?>">
                <img src="<?php echo Url::base() . "/gallery/noimage.gif"; ?>" 
                     style='max-width:95px; max-height:60px;' alt="<?php echo Html::encode($model['name']) ?>" />
            </a>
    </div>
    <div style='margin-left:100px'>
        <div>
            <?php echo Html::a(Html::encode($model['name']), array('adverts/view', 'id' => $model['id'])); ?>
               <?php if ($model['user_id'] == Yii::$app->user->id and Yii::$app->user->id): ?>
                   <a href='<?= Url::to(['adverts/update', 'id' => $model['id']])
                   ?>' class='redact'> редактировать <?= Yii::$app->user->id ?></a>
               <?php endif ?>
        </div>
        <div><?php echo Html::encode(mb_substr($model['text'], 0, 220)); ?></div>
    </div>
</div>