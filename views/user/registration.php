<?php


use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap4\Html;

$this->context->pageTitle = Yii::$app->name . ' - ' . Yii::t('app', "Registration");
$this->params['breadcrumbs'] = ["label" => Yii::t('app', "Registration")];
?>

    <h1><?php echo Yii::t('app', "Registration"); ?></h1>

<?php if (Yii::$app->session->hasFlash('registration')): ?>
    <div class="success">
        <?php echo Yii::$app->session->getFlash('registration'); ?>
    </div>
<?php else: ?>

    <div class="form well">
        <?php
        $form = ActiveForm::begin(array(
            'id' => 'registration-form',
        ));
        ?>
        <?php echo $form->field($model, 'username'); ?>
        <?php echo $form->field($model, 'password')->passwordInput(); ?>
        <?php echo $form->field($model, 'verifyPassword')->passwordInput(); ?>
        <?php echo $form->field($model, 'email'); ?>
        <?php echo $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

        <?php
        /*
                $profileFields = $profile->getFields();

                if ($profileFields) {
                    foreach ($profileFields as $field) {
                        ?>
                        <div>
                            <?php echo $form->field($profile, $field->varname); ?>
                            <?php
                            if ($widgetEdit = $field->widgetEdit($profile)) {
                                echo $widgetEdit;
                            } elseif ($field->range) {
                                echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                            } elseif ($field->field_type == "TEXT") {
                                echo $form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50));
                            } else {
                                echo $form->textField($profile, $field->varname, array('size' => 60, 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                            }
                            ?>
                            <?php echo $form->field($profile, $field->varname); ?>
                        </div>
                        <?php
                    }
                }
        */
        ?>
        <div class="form-group">
            <?php echo Html::submitButton(Yii::t('app', 'Register'), ['class' => 'btn btn-primary']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div><!-- form -->
<?php endif; ?>