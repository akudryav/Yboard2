<?php

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;

$this->beginContent('@app/views/layouts/main.php');

$sideItems = [
    [
        'label' => 'Мои объявления',
        'url' => ['/lk/adverts'],
    ],
    [
        'label' => 'Мои сообщения',
        'url' => ['/lk/messages'],
    ],
    [
        'label' => 'Закладки',
        'url' => ['/lk/adverts/favorites'],
    ],
    [
        'label' => 'Профиль',
        'url' => ['/lk/profile'],
    ],
];
?>
    <div class="col-12 col-lg-9 content_page__content">
        <?= $content ?>
    </div>
    <div class="col-12 col-lg-3 content_page__sidebar">
        <?php echo Yii::$app->user->identity->getAvatar(); ?>
        <?php echo Nav::widget([
            'items' => $sideItems,
        ]); ?>
    </div>

<?php $this->endContent(); ?>