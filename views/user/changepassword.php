<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->context->pageTitle = Yii::$app->name . ' - ' . Yii::t('user', 'Change password');

$form = ActiveForm::begin();
echo $form->field($model, 'password');
echo $form->field($model, 'verifyPassword');

?>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('user', 'Change'), ['class' => 'btn btn-primary']); ?>
    </div>

<?php ActiveForm::end(); ?>