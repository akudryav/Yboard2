<?php

namespace app\models;

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
            array('username', 'length', 'max' => 20, 'min' => 3, 'message' => t("Incorrect username (length between 3 and 20 characters).")),
            array('password', 'length', 'max' => 128, 'min' => 4, 'message' => t("Incorrect password (minimal length 4 symbols).")),
            array('email', 'email'),
            array('username', 'unique', 'message' => t("This user's name already exists.")),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
            array('email', 'unique', 'message' => t("This user's email address already exists.")),
            //array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => t("Retype Password is incorrect.")),
            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => t("Incorrect symbols (A-z0-9).")),

        );

        return $rules;
    }

}
