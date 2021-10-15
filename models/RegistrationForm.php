<?php

namespace app\models;
use Yii;

/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {

    public $verifyPassword;
    public $verifyCode;

    public function rules() {
        $rules = array(

            array(['username', 'password', 'verifyPassword', 'email'], 'required'),
            ['username', 'string', 'length' => [3, 20], 'message' => Yii::t('app', "Incorrect username (length between 3 and 20 characters).")],
            ['password', 'string', 'length' => [4, 128], 'message' => Yii::t('app', "Incorrect password (minimal length 4 symbols).")],
            array('email', 'email'),
            array('username', 'unique', 'message' => Yii::t('app', "This user's name already exists.")),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => null, 'on' => 'insert'),
            array('email', 'unique', 'message' => Yii::t('app', "This user's email address already exists.")),
            array('username', 'unique', 'message' => Yii::t('app', "This username already exists.")),
            //array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => t("Retype Password is incorrect.")),
            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => Yii::t('app', "Incorrect symbols (A-z0-9).")),

        );

        return $rules;
    }

}
