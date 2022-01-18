<?php

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Nav;

$this->beginContent('@app/views/layouts/backend.php');

echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
$sideItems = [
    ['label' => 'Объявления', 'url' => ['/moderator']]
];

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