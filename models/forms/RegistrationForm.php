<?php

namespace app\models\forms;

use app\models\Profile;
use Yii;
use app\models\User;
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends \yii\base\Model
{

    public $username;
    public $password;
    public $email;
    public $verifyPassword;
    public $verifyCode;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('user', "This username already exists.")],
            ['username', 'string', 'min' => 3, 'max' => 20],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t('user', "This email address already exists.")],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['verifyPassword', 'required'],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('user', "Passwords don't match")],
            ['username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => Yii::t('user', "Incorrect symbols (A-z0-9).")],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', "Id"),
            'username' => Yii::t('user', "username"),
            'password' => Yii::t('user', "password"),
            'verifyPassword' => Yii::t('user', "Retype Password"),
            'email' => Yii::t('app', "E-mail"),
            'verifyCode' => Yii::t('app', "Verification Code"),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if ($user->save()) {
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->save(false);
            return $user;
        }
    }


}
