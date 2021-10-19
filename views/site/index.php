<?php
/* @var $this SiteController */
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->context->pageTitle = Yii::$app->name;

$ic = 0;

if( is_array(Yii::$app->params['categories']) )
foreach (Yii::$app->params['categories'] as $cat) {
    if ($cat['icon'] and $cat['level'] == 1) {

        if ($ic == 0) {
            ?>
            <table class="main-cats" cellspacing='10'>
                <tbody> <tr>
                    <?php }
                    if ($ic % 3 == 0) {
                        ?>
                    </tr> 
                <?php                 }

                echo "<td><div>" . Html::a("<img src='" . Url::base() . "/images/category/" . $cat['icon'] . "' /><span>" . $cat['name'] . "</span>", array('adverts/category', 'cat_id' => $cat['id'])) . "</div></td>";


                $ic ++;
            }
        }
 

        ?>                   
        </tr> </tbody> </table>                   

<h3> Последние объявления </h3>

<div class="container">
<?php
       echo ListView::widget([
            'dataProvider' => $indexAdv,
            'itemView' => '/adverts/_view',
            'itemOptions' => ['class' => 'row']
        ]  );

?>
</div>


