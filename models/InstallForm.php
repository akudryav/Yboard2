<?php

namespace app\models;

use Yii;
use yii\base\Model;

class InstallForm extends Model {

    public $mysql_server;
    public $mysql_login;
    public $mysql_password;
    public $mysql_db_name;
    public $site_name;
    public $username;
    public $userpass;
    public $userpass2;
    public $useremail;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'userpass', 'userpass2', 'useremail', 'site_name',
                'mysql_server', 'mysql_login', 'mysql_password', 'mysql_db_name'], 'required'],
            ['useremail', 'email'],
            ['username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u',
                'message' => Yii::t('lang', "Incorrect symbols (A-z0-9).")
            ],
            ['userpass', 'compare', 'compareAttribute' => 'userpass2',
                'message' => Yii::t('lang', "Retype Password is incorrect.")
            ]
        ];
    }
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'site_name' => 'Название сайта',
            'mysql_server' => 'Сервер mysql',
            'mysql_login' => 'Login Mysql',
            'mysql_password' => 'Пароль Mysql',
            'mysql_db_name' => 'Название базы',
            'username' => 'Логин для входа в админку',
            'userpass' => 'Пароль',
            'userpass2' => 'Пароль еще раз',
            'useremail' => 'Емайл администратора',
        );
    }

}
