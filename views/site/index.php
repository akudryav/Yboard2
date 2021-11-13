<?php
/* @var $this SiteController */

use yii\widgets\ListView;
use yii\helpers\Url;

$this->context->title = Yii::$app->name;

?>

<h3>Выберите категорию</h3>
<?php if (is_array($roots)):
    $batch = array_chunk($roots, 4);
    $start = 0;
    ?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($batch as $b): ?>
                <div class="carousel-item <?php if (0 == $start) echo 'active'; ?>">
                    <?php foreach ($b as $cat):
                        $url = Url::to(['adverts/category', 'id' => $cat->id]);
                        ?>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <a href="<?= $url ?>">
                                <img src="/images/category/<?= $cat->icon ?>" alt="<?= $cat->name ?>"
                                     class="img-responsive">
                                <div class="carousel-caption d-none d-md-block"><h5><?= $cat->name ?></h5></div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php $start++; ?>
            <?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

<?php endif; ?>

<h3>Все объявления</h3>

<?php echo ListView::widget([
    'dataProvider' => $indexAdv,
    'options' => ['class' => 'card-deck'],
    'summary' => '',
    'itemOptions' => [
        'tag' => false,
    ],
    'itemView' => '/adverts/_item',
]);
?>


