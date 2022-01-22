<?php

use rmrevin\yii\ulogin\ULogin;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$model = new app\models\forms\LoginForm();

?>
<div class="modal-popup modal-auth" style="display: none;" id="auth">
    <div class="modal-popup__content">
        <a class="modal-popup__close"></a>
        <div class="modal-auth__content">
            <div class="modal-auth__benefits">
                <ul class="modal-auth__benefits_list">
                    <li class="modal-auth__benefits_item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                            <path d="M0 0h24v24H0z" fill="none"></path>
                        </svg>
                        <span class="modal-auth__benefits_title">Общайтесь</span>
                        <span class="modal-auth__benefits_descr">по объявлениям в чатах</span>
                    </li>
                    <li class="modal-auth__benefits_item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                            <path d="M0 0h24v24H0z" fill="none"></path>
                        </svg>
                        <span class="modal-auth__benefits_title">Размещайте</span>
                        <span class="modal-auth__benefits_descr">объявления бесплатно</span>
                    </li>
                    <li class="modal-auth__benefits_item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                            <path d="M0 0h24v24H0z" fill="none"></path>
                        </svg>
                        <span class="modal-auth__benefits_title">Покупайте со скидкой</span>
                        <span class="modal-auth__benefits_descr">по безопасной сделке</span>
                    </li>
                    <li class="modal-auth__benefits_item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                            <path d="M0 0h24v24H0z" fill="none"></path>
                        </svg>
                        <span class="modal-auth__benefits_title">Покупайте с доставкой</span>
                        <span class="modal-auth__benefits_descr">по всей России</span>
                    </li>
                    <li class="modal-auth__benefits_item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                            <path d="M0 0h24v24H0z" fill="none"></path>
                        </svg>
                        <span class="modal-auth__benefits_title">Подписывайтесь</span>
                        <span class="modal-auth__benefits_descr">на продавцов и добавляйте объявления в избранное</span>
                    </li>
                </ul>
            </div>
            <div class="modal-auth__form">
                <div class="modal-auth__form_title">Вход и регистрация</div>
                <div class="modal-auth__form_descr">по номеру телефона</div>
                <div class="modal-auth__form_input"><input class="auth__form_input_phone" type="text" name="phone"
                                                           value=""></div>
                <div class="modal-auth__form_submit"><input class="default_btn auth__form_input_submit" type="submit"
                                                            value="Продолжить"></div>
                <div class="modal-auth__social">
                    <div class="modal-auth__social_title">или через соцсети</div>
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
                </div>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'action' => ['user/login'],
                    'options' => [
                        'class' => 'hidden'
                    ],
                ]);

                echo $form->field($model, 'username');
                echo $form->field($model, 'password')->passwordInput();
                echo $form->field($model, 'rememberMe')->checkbox();
                ?>
                <div class="form-group">
                    <?php
                    echo Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary']);
                    echo Html::a(Yii::t('user', "Lost Password?"), ['user/recovery']);
                    ?>
                </div>

                <?php ActiveForm::end(); ?>
                <div class="modal-auth__login">
                    <a href="#" class="js_form_login">У меня есть логин и пароль</a>
                    <a href="/user/registration"><?= Yii::t('user', 'Register') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>