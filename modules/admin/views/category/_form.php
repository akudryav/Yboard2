<?php

use app\models\forms\ParamForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="form">

    <?php $form = ActiveForm::begin(['id' => 'category-form',]);

    echo $form->field($model, 'name')->textInput(['maxlength' => true]);
    echo $form->field($model, 'parentId')->widget(Select2::class, [
        'data' => Category::makeOptionsList($model->id),
        'options' => ['placeholder' => Yii::t('app', 'No Parent (saved as root)')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    echo $form->field($model, 'position')->textInput(['type' => 'number']);
    echo $form->field($model, 'params_flag')->checkbox();
    ?>

    <ol id="ref_book_items" class="list-group">
        <?php
        $count = count($params);
        $templateModel = new ParamForm();
        $templateModel->code = uniqid();
        ?>
        <?php foreach ($params as $index => $item): ?>
            <li class="list-group-item">
                <div class="row">
                    <?= $form->field($item, "[$index]code")->hiddenInput()->label(false) ?>
                    <div class="col-md-auto"><?= $form->field($item, "[$index]name")->textInput() ?></div>
                    <div class="col-md-auto"><?php
                        echo $form->field($item, "[$index]values")->widget(Select2::class, [
                            'data' => $item['values'],
                            'language' => 'ru',
                            'options' => ['multiple' => true, 'placeholder' => 'Добавить значение', 'class'=>'is-select2'],
                            'pluginOptions' => [
                                'tokenSeparators' => [',', ', '],
                                'allowClear' => true,
                                'tags' => true,
                            ],
                        ]);
                        ?></div>
                    <div class="col-md-auto">
                        <a class="text-danger delete-item"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>

    </ol>
        <button type="button" id="add-new-item" class="btn btn-primary"><i class="fa fa-plus"></i></button>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <li id="template" class="list-group-item">
        <div class="row">
            <?= $form->field($templateModel, "[0]code")->hiddenInput()->label(false) ?>
            <div class="col-md-auto"><?= $form->field($templateModel, "[0]name")->textInput() ?></div>
            <div class="col-md-auto"><?php
                echo $form->field($templateModel, "[0]values")->widget(Select2::class, [
                    'data' => [],
                    'language' => 'ru',
                    'options' => ['multiple' => true, 'placeholder' => 'Добавить значение', 'class'=>'is-select2'],
                    'pluginOptions' => [
                        'tokenSeparators' => [',', ', '],
                        'allowClear' => true,
                        'tags' => true,
                    ],
                ]);
                ?></div>
            <div class="col-md-auto">
                <a class="text-danger delete-item"><i class="fa fa-times"></i></a>
            </div>
        </div>
    </li>

</div>