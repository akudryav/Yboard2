<?php

use rmrevin\yii\ulogin\ULogin;

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->context->pageTitle = Yii::$app->name . ' - ' . Yii::t('app', "Login");
$this->params['breadcrumbs'] = [
    Yii::t('app', "Login"),
];
?>

<h1><?php echo Yii::t('app', "Login"); ?></h1>

<?php if (Yii::$app->session->getFlash('loginMessage')): ?>

    <div class="success">
        <?php echo Yii::$app->session->getFlash('loginMessage'); ?>
    </div>

<?php endif; ?>


<div class="form well">
    <h3><?= Yii::t('app', 'Social networks authorisation :') ?></h3>


    <?php echo ULogin::widget([
        // widget look'n'feel
        'display' => ULogin::D_PANEL,
        // required fields
        'fields' => [ULogin::F_FIRST_NAME, ULogin::F_LAST_NAME, ULogin::F_EMAIL, ULogin::F_PHONE, ULogin::F_CITY, ULogin::F_COUNTRY, ULogin::F_PHOTO_BIG],
        // optional fields
        'optional' => [ULogin::F_BDATE],
        // login providers
        'providers' => [ULogin::P_VKONTAKTE, ULogin::P_FACEBOOK, ULogin::P_TWITTER, ULogin::P_GOOGLE],
        // login providers that are shown when user clicks on additonal providers button
        'hidden' => [],
        // where to should ULogin redirect users after successful login
        'redirectUri' => ['user/ulogin'],
        // force use https in redirect uri
        'forceRedirectUrlScheme' => 'http',
        // optional params (can be ommited)
        // force widget language (autodetect by default)
        'language' => ULogin::L_RU,
        // providers sorting ('relevant' by default)
        'sortProviders' => ULogin::S_RELEVANT,
        // verify users' email (disabled by default)
        'verifyEmail' => '0',
        // mobile buttons style (enabled by default)
        'mobileButtons' => '1',
    ]);
    ?>

    <hr/>
    <h3><?= Yii::t('app', 'Authorisation by login:') ?></h3>

    <?php
    $form = ActiveForm::begin(array(
        'id' => 'login-form',
        'enableClientValidation' => true,
    ));
    ?>
    <?php echo $form->field($model, 'username') ?>
    <?php echo $form->field($model, 'password')->passwordInput() ?>
    <?php echo $form->field($model, 'rememberMe')->checkbox(); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary']); ?>
        <?php echo Html::a(Yii::t('app', "Register"), ['user/registration'], ['class' => 'btn btn-info']); ?>
        <?php echo Html::a(Yii::t('app', "Lost Password?"), ['user/recovery'], ['class' => 'btn btn-warning']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
