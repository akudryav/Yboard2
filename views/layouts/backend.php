<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Category;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use kartik\bs4dropdown\Dropdown;
use app\widgets\Alert;

use app\assets\AdminAsset;

AdminAsset::register($this);

$searchStr = Yii::$app->request->get('searchStr');

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
                'class' => 'navbar navbar-expand-sm navbar-dark bg-primary',
            ],
        ]);
        $menuItems = [
            [
                'label' => '<i class="far fa-envelope"></i> Сообщения',
                'url' => ['/lk/messages'],
                'encode' => false
            ],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Вход', 'url' => ['/user/login']];
            $menuItems[] = ['label' => 'Регистрация', 'url' => ['/user/registration']];
        } else {
            if(Yii::$app->user->isAdmin()) {
                $menuItems[] = ['label' => 'Админка', 'url' => ['/admin/category']];
            } elseif(Yii::$app->user->isModer()) {
                $menuItems[] = ['label' => 'Модерация', 'url' => ['/moderator']];
            }
            $menuItems[] = [
                'encode' => false,
                'label' => 'Выйти ' . Yii::$app->user->identity->getAvatar(30),
                'url' => ['/user/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }
        // Выпадающий список категорий
        echo Nav::widget([
            'items' => [
                [
                    'label' => 'Категории',
                    'items' => Category::makeDropList(),
                ],
            ],
            'dropdownClass' => Dropdown::class, // use the custom dropdown
            'options' => ['class' => 'navbar-nav'],
        ]);

        ?>
        <form class="form-inline" action="/adverts/search">
            <input class="form-control mr-sm-2" type="text" name="searchStr" value="<?=$searchStr?>" placeholder="Поиск">
            <button class="btn btn-secondary" type="submit">Найти</button>
        </form>
        <?php
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
            <?php /*['label' => 'О нас', 'url' => ['/page/about']],
            ['label' => 'Контакты', 'url' => ['/site/contact']],*/ ?>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>