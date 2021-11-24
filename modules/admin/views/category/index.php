<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

use app\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cat', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('cat', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['width' => '70px']
            ],
            'name',
            [
                'attribute' => 'tree',
                'filter' => Category::find()->roots()->select('name, id')->indexBy('id')->column(),
                'value' => function ($model)
                {
                    if ( ! $model->isRoot())
                        return $model->parents()->one()->name;

                    return null;
                }
            ],
            [
                'attribute' => 'parentId',
                'value' => 'parent.name',
            ],
            // 'lft',
            // 'rgt',
            // 'depth',
            'position',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => ['white-space' => 'nowrap']],
            ],
        ],
    ]); ?>
    </div>