<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->context->pageTitle = Yii::$app->name . ' - ' . Yii::t('user', 'Password recovery');

$form = ActiveForm::begin();
echo $form->field($model, 'login_or_email');

?>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('user', 'Recover'), ['class' => 'btn btn-primary']); ?>
    </div>

<?php ActiveForm::end(); ?>