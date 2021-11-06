<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->context->title = Yii::$app->name . ' - ' . Yii::t('user', 'Change password');

$form = ActiveForm::begin();
echo $form->field($model, 'password');
echo $form->field($model, 'verifyPassword');

?>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('user', 'Change'), ['class' => 'btn btn-primary']); ?>
    </div>

<?php ActiveForm::end(); ?>