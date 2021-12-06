<?php
/* @var $this BulletinController */
/* @var $model Bulletin */


use yii\grid\GridView;
use yii\widgets\Menu;
use yii\bootstrap4\Html;

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('app', 'List Bulletin'), 'icon' => 'icon-list', 'url' => array('index'), "itemOptions" => array('class' => 'btn')),
        array('label' => Yii::t('app', 'Create Bulletin'), 'icon' => 'icon-plus', 'url' => array('create'), "itemOptions" => array('class' => 'btn')),
    )
]);

?>


<h1><?php echo Yii::t('app', 'Manage Bulletins'); ?></h1>


<?php echo Html::a(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->render('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php


echo GridView::widget( array(
    'id' => 'bulletin-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(// display 'create_time' using an expression
            'class' => 'yii\grid\SerialColumn',
            'header' => Yii::t('app', 'name'),
        ),
        array(// display 'create_time' using an expression
            'class' => 'yii\grid\SerialColumn',
            'header' => Yii::t('app', 'user_id'),
        ),
        array(
            'class' => 'yii\grid\SerialColumn',
            'header' => Yii::t('app', 'moderated'),
        ),
        array(
            'value' => '$data->category->name',
        ),
        'views',
        /*
          'text',
         */
        array(
            'class' => 'yii\grid\SerialColumn',
        ),
    ),
));
?>


<script>

    $('a.moder').click(function (e) {
        e.preventDefault();
        $.get($(this).attr('href').toString(), function (data) {
            if (data == "ok")
                }
        $(this).parent().html("Отмодереровано");
    )
    });

</script>

