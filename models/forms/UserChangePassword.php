<?php
namespace app\models\forms;

use Yii;
/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangePassword extends \yii\base\Model
{

    public $password;
    public $verifyPassword;

    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['verifyPassword', 'required'],
            ['verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', "Passwords don't match")],
        ];
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'password' => Yii::t('app', "password"),
            'verifyPassword' => Yii::t('app', "Retype Password"),
        );
    }

    public function process($user)
    {
        if (!$this->validate()) {
            return null;
        }

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->password_reset_token = null;
        return $user->save();
    }

}
