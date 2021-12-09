<?php

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;

$this->beginContent('@app/views/layouts/main.php');

echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
$sideItems = [
    //['label' => 'Профиль', 'url' => ['user/profile']],
    [
        'label' => '<i class="fas fa-list-ul"></i> Мои объявления',
        'url' => ['/lk/adverts'],
        'encode' => false
    ],
    [
        'label' => '<i class="far fa-envelope"></i> Мои сообщения',
        'url' => ['/lk/messages'],
        'encode' => false
    ],
    [
        'label' => '<i class="far fa-heart"></i> Закладки',
        'url' => ['/lk/adverts/favorites'],
        'encode' => false
    ],
    [
        'label' => '<i class="fas fa-cog"></i> Профиль',
        'url' => ['/lk/profile'],
        'encode' => false
    ],
];
?>
<?php echo Yii::$app->user->identity->getAvatar(); ?>
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