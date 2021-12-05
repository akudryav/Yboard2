<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use kartik\select2\Select2;
use app\models\Category;
use app\models\forms\ParamForm;

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
    $count = count($params);
    ?>
    <div id="ref_book_items" <?php if ($count == 0) echo 'style="display: none;"';?>>
        <ol class="list-group">
        <?php foreach ($params as $index => $item): ?>
            <li class="list-group-item">
                <div class="input-group">
                    <?php
                    echo $form->field($item, "[$index]name", ['options' => ['tag' => false]]);
                    echo Html::a('Список значений (если нужно)', '#',
                        [
                            'class' => 'btn btn-outline-secondary',
                            'data-toggle' => 'modal',
                            'data-target' => '#catModal',
                            'data-name'   => "ParamForm[$index][values]"
                        ]
                    );
                    echo Html::a('Удалить', '#',
                        ['class' => 'btn btn-outline-danger delete-item']
                    );
                    echo $form->field($item, "[$index]code", ['options' => ['tag' => false]])->hiddenInput()->label(false);
                    echo $form->field($item, "[$index]values", ['options' => ['tag' => false]])->hiddenInput()->label(false);
                    ?>
                </div>
            </li>
        <?php endforeach; ?>
            <?php
            if ($count == 0):
                $templateModel = new ParamForm();
                $templateModel->code = uniqid();
                ?>
                <li class="list-group-item">
                    <div class="input-group">
                <?php
                    echo $form->field($templateModel, "[0]name", ['options' => ['tag' => false]]);
                    echo Html::a('Список значений (если нужно)', '#',
                        [
                            'class' => 'btn btn-outline-secondary',
                            'data-toggle' => 'modal',
                            'data-target' => '#catModal',
                            'data-name'   => "ParamForm[0][values]"
                        ]
                    );
                    echo Html::a('Удалить', '#',
                        ['class' => 'btn btn-outline-danger delete-item']
                    );
                    echo $form->field($templateModel, "[0]code", ['options' => ['tag' => false]])->hiddenInput()->label(false);
                    echo $form->field($templateModel, "[0]values", ['options' => ['tag' => false]])->hiddenInput()->label(false);
                ?>
                    </div>
                </li>
            <?php endif; ?>
        </ol>
        <div class="form-group">
        <?= Html::button('<i class="fa fa-plus"></i>', ['id' => 'add-new-item', 'class' => 'btn btn-info']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

Modal::begin([
    'id' => 'catModal',
    'title' => 'Список допустимых значений',
    'footer' => '<button type="button" class="btn btn-info">Сохранить</button>
<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>',
]);

echo Html::textArea('optionsList', '',
    ['id' => 'optionsList', 'class' => 'form-control', 'placeholder' => 'Введите варианты на отдельных строках']);

Modal::end();
?>