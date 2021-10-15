<?php
$this->context->pageTitle = Yii::$app->name . ' - ' . Yii::t('app', "Change Password");
echo Breadcrumbs::widget(array(
    Yii::t('app', "Login") => array('/user/login'),
    Yii::t('app', "Change Password"),
));
?>

<h1><?php echo Yii::t('app', "Change Password"); ?></h1>


<div class="form">
    <?php echo Html::beginForm(); ?>

    <p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>
    <?php echo Html::errorSummary($form); ?>

    <div class="row">
        <?php echo Html::activeLabelEx($form, 'password'); ?>
        <?php echo Html::activePasswordField($form, 'password'); ?>
        <p class="hint">
            <?php echo Yii::t('app', "Minimal password length 4 symbols."); ?>
        </p>
    </div>

    <div class="row">
        <?php echo Html::activeLabelEx($form, 'verifyPassword'); ?>
        <?php echo Html::activePasswordField($form, 'verifyPassword'); ?>
    </div>


    <div class="row submit">
        <?php echo Html::submitButton(Yii::t('app', "Save")); ?>
    </div>

    <?php echo Html::endForm(); ?>
</div><!-- form -->