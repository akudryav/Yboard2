<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

/* @var $user User */

use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap4\Html;

$this->context->pageTitle = Yii::$app->name . ' - Обратная связь';
$this->params['breadcrumbs'] = array(
    'Обратная связь',
);

$this->params['breadcrumbs'] = array('Обратная связь');
?>

    <h1>Отправить сообщение <?php echo $user ? $user->username : 'администратору'; ?></h1>


<div class="form">

    <?php
    $form = ActiveForm::begin(array(
        'id' => 'conactForm',
        'options' => array('class' => 'well'),
    ));
    ?>

    <?php echo $form->field($model, 'name')->textInput(); ?>

    <?php echo $form->field($model, 'email')->textInput(); ?>

    <?php echo $form->field($model, 'subject')->textInput(); ?>

    <?php echo $form->field($model, 'body')->textarea(['rows' => 6, 'cols' => 50]); ?>

    <?php echo $form->field($model, 'verifyCode')->widget(Captcha::class) ?>

    <?php echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div><!-- form -->
