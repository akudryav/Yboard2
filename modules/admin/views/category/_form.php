<?php

use app\models\forms\ParamForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use app\models\Category;
use yii\bootstrap4\Modal;

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
    <div id="ref_book_items">
        <ol class="list-group">
            <?php
        $count = count($params);
        $templateModel = new ParamForm();
        $templateModel->code = uniqid();
        ?>
        <?php foreach ($params as $index => $item): ?>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-auto"><?= $form->field($item, "[$index]name")->textInput() ?></div>
                    <div class="col-md-auto">
                        <?= $form->field($item, "[$index]code")->hiddenInput()->label(false) ?>
                        <?= $form->field($item, "[$index]values")->hiddenInput()->label(false) ?>
                    </div>
                    <div class="col-md-auto">
                        <?php echo Html::a('Ввести значения', '#',
                            ['data-toggle' => 'modal', 'data-target' => '#catModal', 'data-index' => $index]
                        );
                        echo Html::a('Удалить', '#',
                            ['class' => 'text-danger delete-item']
                        );
                        ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
            <?php if ($count == 0): ?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-auto"><?= $form->field($templateModel, "[0]name")->textInput() ?></div>
                        <div class="col-md-auto">
                            <?= $form->field($templateModel, "[0]code")->hiddenInput()->label(false) ?>
                            <?= $form->field($templateModel, "[0]values")->hiddenInput()->label(false) ?>
                        </div>
                        <div class="col-md-auto">
                            <?php echo Html::a('Ввести значения', '#',
                                ['data-toggle' => 'modal', 'data-target' => '#catModal', 'data-index' => 0]
                            );
                            echo Html::a('Удалить', '#',
                                ['class' => 'text-danger delete-item']
                            );
                            ?>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
        </ol>
        <?= Html::button('<i class="fa fa-plus"></i>', ['id' => 'add-new-item', 'class' => 'btn btn-info']) ?>
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