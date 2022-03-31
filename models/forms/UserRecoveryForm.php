<?php
namespace app\models\forms;

use Yii;
use app\models\User;

/**
 * UserRecoveryForm class.
 * UserRecoveryForm is the data structure for keeping
 * user recovery form data. It is used by the 'recovery' action of 'UserController'.
 */
class UserRecoveryForm extends \yii\base\Model
{

    public $login_or_email;

    public function rules()
    {
        return [
            ['login_or_email', 'trim'],
            ['login_or_email', 'required'],
            ['login_or_email', 'checkexists'],
        ];
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'login_or_email' => Yii::t('user', "username or email"),
        );
    }

    public function checkexists($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByUsername($this->$attribute);

            if ($user === null) {
                $msg = strpos($this->$attribute, '@') ?
                    Yii::t('user', 'Email is incorrect.') :
                    Yii::t('user', 'Username is incorrect.');
                $this->addError($attribute, $msg);
            }
        }
    }

    public function process()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findByUsername($this->login_or_email);
        $user->generatePasswordToken();
        $activation_url = Yii::$app->urlManager->createAbsoluteUrl(['user/recovery', 'token' => $user->password_reset_token], 'http');

        $subject = Yii::t('user', 'Password recovery site {site_name}', array(
            'site_name' => Yii::$app->name,
        ));
        $message = Yii::t('user', 'You have requested the password recovery site {site_name}. To receive a new password, go to {activation_url}.',
            [
                'site_name' => Yii::$app->name,
                'activation_url' => $activation_url,
            ]);

        Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($user->email)
            ->setSubject($subject)
            ->setTextBody($message)
            ->send();

        return $user->save();
    }

}
