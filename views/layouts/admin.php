<?php

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;

$this->beginContent('@app/views/layouts/backend.php');

echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
$sideItems = array(

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
    array('label' => "Баннерные блоки", 'url' => array('banners/index')),
    array('label' => "Почтовая рассылка", 'url' => array('admin/delivery')),
    array('label' => "Настройки", 'url' => array('admin/settings')),
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