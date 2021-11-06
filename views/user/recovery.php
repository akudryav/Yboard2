<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->context->title = Yii::$app->name . ' - ' . Yii::t('user', 'Password recovery');

$form = ActiveForm::begin();
echo $form->field($model, 'login_or_email');

?>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('user', 'Recover'), ['class' => 'btn btn-primary']); ?>
    </div>

<?php ActiveForm::end(); ?>