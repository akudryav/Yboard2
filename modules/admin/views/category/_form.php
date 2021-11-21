<?php

use app\models\forms\ParamForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use app\models\Category;
use app\assets\CategoryAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
CategoryAsset::register($this);
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'parentId')->widget(Select2::class, [
        'data' => Category::makeOptionsList($model->id),
        'options' => ['placeholder' => Yii::t('app', 'No Parent (saved as root)')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'position')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'params_flag')->checkbox() ?>
    <div id="ref_book_items" class="dd">
        <ol class="dd-list">
            <?php
            $count = count($params);
            $templateModel = new ParamForm();
            $templateModel->code = uniqid();
            ?>
            <?php foreach ($params as $index => $item): ?>
                <li class="dd-item">
                    <div class="row">
                        <?= $form->field($item, "[$index]code")->hiddenInput()->label(false) ?>
                        <div class="col"><?= $form->field($item, "[$index]name")->textInput() ?></div>
                        <div class="col"><?php
                            echo $form->field($item, "[$index]values")->widget(Select2::class, [
                                'data' => $item['values'],
                                'language' => 'ru',
                                'options' => ['multiple' => true, 'placeholder' => 'Добавить значение'],
                                'pluginOptions' => [
                                    'tokenSeparators' => [',', ', '],
                                    'allowClear' => true,
                                    'tags' => true,
                                ],
                            ]);
                            ?></div>
                        <div class="col">
                            <a class="text-danger delete-link delete-item"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
            <li class="dd-item template">
                <div class="row">
                    <?= $form->field($templateModel, "[$count]code")->hiddenInput()->label(false) ?>
                    <div class="col"><?= $form->field($templateModel, "[$count]name")->textInput() ?></div>
                    <div class="col"><?php
                        echo $form->field($templateModel, "[$count]values")->widget(Select2::class, [
                            'data' => [],
                            'language' => 'ru',
                            'options' => ['multiple' => true, 'placeholder' => 'Добавить значение'],
                            'pluginOptions' => [
                                'tokenSeparators' => [',', ', '],
                                'allowClear' => true,
                                'tags' => true,
                            ],
                        ]);
                        ?></div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                        <a class="text-danger delete-link delete-item"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </li>
        </ol>
    </div>
    <div class="form-group">
        <button type="button" id="add-new-item" class="btn btn-primary">Добавить</button>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>