<?php
namespace app\models\forms;

use Yii;
/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends \yii\base\Model
{

    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'name' => 'Имя',
            'email' => 'Ваш E-mail',
            'subject' => 'Тема сообщения',
            'body' => 'Сообщение',
            'verifyCode' => 'Проверочный код',
        );
    }

    public function process($user)
    {
        if (!$this->validate()) {
            return null;
        }
        $email = isset($user->email) ? $user->email : Yii::$app->params['adminEmail'];
        return Yii::$app->mailer->compose()
            ->setFrom($email)
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }

}
