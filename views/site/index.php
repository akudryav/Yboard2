<?php
/* @var $this SiteController */

use yii\widgets\ListView;
use yii\helpers\Url;

$this->context->pageTitle = Yii::$app->name;
//array('adverts/category', 'cat_id' => $cat['id']))

?>

<?php if (is_array(Yii::$app->params['categories'])):
    $batch = array_chunk(Yii::$app->params['categories'], 3);
    $start = 0;
    ?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Показатели -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <!-- Обертка для слайдов -->
        <div class="carousel-inner" role="listbox">
            <?php foreach ($batch as $b): ?>
                <div class="item <?php if (0 == $start) echo 'active'; ?>">
                    <div class="row">
                        <?php foreach ($b as $cat):
                            $url = Url::to(['adverts/category', 'id' => $cat['id']]);
                            ?>
                            <div class="col-xs-3">
                                <a href="<?= $url ?>">
                                    <img src="/images/category/<?= $cat['icon'] ?>" alt="<?= $cat['name'] ?>"
                                         class="img-responsive">
                                    <div class="carousel-caption"><h3><?= $cat['name'] ?></h3></div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php $start++; ?>
            <?php endforeach; ?>
        </div>
        <!-- Элементы управления -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
<?php endif; ?>

<h3> Последние объявления </h3>

<div class="container">
    <?php
    echo ListView::widget([
        'dataProvider' => $indexAdv,
        'itemView' => '/adverts/_item',
    ]);
    ?>
</div>


