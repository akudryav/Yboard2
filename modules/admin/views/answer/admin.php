<?php
/* @var $this AnswerController */
/* @var $model Answer */


use yii\helpers\Html;
use yii\widgets\Menu;

$this->params['breadcrumbs'] = array(
    ['label' => Yii::t('lang', 'Answers'), 'url' => array('index')],
    Yii::t('lang', 'Manage'),
);

echo Menu::widget([
    'items' => array(
        array('label' => Yii::t('lang', 'List Answer'), 'icon' => 'icon-list', 'url' => array('index')),
        array('label' => Yii::t('lang', 'Create Answer'), 'icon' => 'icon-plus', 'url' => array('create')),
    )
]);

Yii::$app->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#answer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php Yii::t('lang', 'Manage Answers'); ?></h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo Html::a('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->render('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
echo GridView::widget( array(
    'type' => 'striped bordered condensed',
    'id' => 'answer-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'parent_id',
        'user_id',
        'text',
        'created_at',
        'updated_at',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'options' => array('style' => 'width: 50px'),
        ),
    ),
));
?>
