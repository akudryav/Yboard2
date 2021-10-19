<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

/* @var $user User */

use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->context->pageTitle = Yii::$app->name . ' - Обратная связь';
$this->params['breadcrumbs'] = array(
    'Обратная связь',
);

$this->params['breadcrumbs'] = array('Обратная связь');
?>

    <h1>Отправить сообщение <?php echo $user ? $user->username : 'администратору'; ?></h1>


    <div class="form">


        <?php
        $form = ActiveForm::begin( array(
            'id' => 'conactForm',
            'options' => array('class' => 'well'),
        ));
        ?>


        <p class="note">Поля, обязательные для заполнения, помечены звездочкой (<span class="required">*</span>).</p>

        <?php echo $form->errorSummary($model); ?>

        <div>
            <?php echo $form->field($model, 'name')->textInput(); ?>
        </div>

        <div>
            <?php echo $form->field($model, 'email')->textInput(); ?>
        </div>

        <div>
            <?php echo $form->field($model, 'subject')->textInput(); ?>
        </div>

        <div>
            <?php echo $form->field($model, 'body')->textarea(['rows' => 6, 'cols' => 50]); ?>
        </div>

        <div>
            <?php echo $form->field($model, 'verifyCode')->widget(Captcha::class) ?>
        </div>

        <?php echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end(); ?>
    </div><!-- form -->
