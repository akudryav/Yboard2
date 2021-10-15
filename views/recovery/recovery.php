<?php
$this->context->pageTitle = Yii::$app->name . ' - ' . Yii::t('app', "Restore");
echo Breadcrumbs::widget(array(
    Yii::t('app', "Login") => array('/user/login'),
    Yii::t('app', "Restore"),
));
?>

    <h1><?php echo Yii::t('app', "Restore"); ?></h1>

<?php if (Yii::$app->user->hasFlash('recoveryMessage')): ?>
    <div class="success">
        <?php echo Yii::$app->session->getFlash('recoveryMessage'); ?>
    </div>
<?php else: ?>

    <div class="form">
        <?php echo Html::beginForm(); ?>

        <?php echo Html::errorSummary($form); ?>

        <div class="row">
            <?php echo Html::activeLabel($form, 'login_or_email'); ?>
            <?php echo Html::activeTextInput($form, 'login_or_email') ?>
            <p class="hint"><?php echo Yii::t('app', "Please enter your login or email addres."); ?></p>
        </div>

        <div class="row submit">
            <?php echo Html::submitButton(Yii::t('app', "Restore")); ?>
        </div>

        <?php echo Html::endForm(); ?>
    </div><!-- form -->
<?php endif; ?>