<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\assets\AppAsset;
use app\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script src="https://kit.fontawesome.com/f74a7c5cc1.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'brandOptions' => ['class' => 'col-sm-3 col-md-2 mr-0'],
            'renderInnerContainer' => false,
            'options' => [
                'class' => 'navbar navbar-dark fixed-top bg-primary navbar-expand p-0 shadow',
            ],
        ]);
        $menuItems = [
            ['label' => 'О нас', 'url' => ['/page/about']],
            ['label' => 'Контакты', 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Вход', 'url' => ['/user/login']];
            $menuItems[] = ['label' => 'Регистрация', 'url' => ['/user/registration']];
        } else {
            $menuItems[] = ['label' => 'Личный кабинет', 'url' => ['lk/adverts']];
            $menuItems[] = [
                'label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
                'url' => ['/user/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }
        echo '<input class="form-control form-control-dark w-50" type="text" name="keyword" placeholder="Поиск" aria-label="Search">';
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav justify-content-end px-3'],
            'items' => $menuItems,
        ]);

        NavBar::end();
        ?>

        <div class="container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>