<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;

?>

<div class="form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'profile-form',
    ]);
    ?>
    <?php echo $form->field($model, 'first_name'); ?>
    <?php echo $form->field($model, 'last_name'); ?>
    <?php echo $form->field($model, 'city'); ?>
    <?php echo $form->field($model, 'phone'); ?>
    <?php echo $form->field($model, 'company'); ?>
    <div class="form-group">
        <label class="form-label"><?= Yii::t('user', 'Birth Date') ?></label>
        <?php echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'birthdate',
            'options' => [
                'value' => $model->birthdate ? Yii::$app->formatter->asDate($model->birthdate) : '',
            ],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy',
            ]
        ]);
        ?>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->
