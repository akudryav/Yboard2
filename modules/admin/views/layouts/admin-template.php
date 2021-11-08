<?php

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;

$this->beginContent('@app/views/layouts/main.php');

echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
$sideItems = array(
    array('label' => 'Основное меню',
          'url' => '#',
          "items" => array(
              array('label' => 'Главная страница',
                    'url' => array('site/index')),
              array('label' => 'Добавить объявление',
                    'url' => array('adverts/create')),
              array('label' => 'Правила работы',
                    'url' => array('site/page', 'view' => 'about')),
              array('label' => 'Обратная связь',
                    'url' => array('site/contact')),
              array('url' => array('user/login'),
                    'label' => Yii::t('app', "Login"),
                    'visible' => Yii::$app->user->isGuest),
              array('url' => array('user/registration'),
                    'label' => Yii::t('app', "Register"),
                    'visible' => Yii::$app->user->isGuest),
              array('url' => array('user/profile'),
                    'label' => Yii::t('app', "Profile"),
                    'visible' => !Yii::$app->user->isGuest),
              array('url' => array('user/logout'),
                    'label' => Yii::t('app', "Logout")
                        . ' (' . Yii::$app->user->identity->username . ')',
                    'visible' => !Yii::$app->user->isGuest),
          ),
          'linkOptions' => array('class' => 'menu-dropdown'),
    ),
    array('label' => "Панель администратора",
          'url' => array('adverts/index')),
    array('label' => 'Объявления',
          'url' => "#",
          'items' => array(
              array('label' => "Управление",
                    'url' => array('adverts/index')),
              array('label' => "Добавить объявление",
                    'url' => array('adverts/create')),
          ),
          'linkOptions' => array('class' => 'menu-dropdown'),
    ),
    array('label' => 'Категории', 'url' => array('category/index')),
    array('label' => Yii::t('app', "Pages"), 'url' => array('/cms/cms')),
    array('label' => "Баннерные блоки", 'url' => array('banners/index')),
    array('label' => "Почтовая рассылка", 'url' => array('delivery')),
    array('label' => "Настройки", 'url' => array('default/settings')),
    array('label' => "Помощь", 'url' => array('default/help')),
);
?>
    <div class="row">
        <?php echo Nav::widget([
            'options' => ['class' => 'col-md-2 d-none d-md-block bg-light sidebar'],
            'items' => $sideItems,
        ]); ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <?= $content ?>
        </main>
    </div>

<?php $this->endContent(); ?>