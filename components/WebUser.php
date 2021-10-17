<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 01.03.2019
 * Time: 23:32
 */

namespace app\components;

use Yii;
use yii\web\User;

class WebUser extends User
{
    public function can($permissionName, $params = [], $allowCaching = true)
    {

        if ($permissionName === "admin" and $this->identity->superuser) {
            return true;
        }

        if ($permissionName === "permision" and $this->identity->superuser) {
            return true;
        }

        if( $permissionName === "permision"  ){

            if (class_exists("\\app\\models\\" . ucfirst(Yii::$app->controller->id))) {


            }

            return true;
        }

    }

    public static function crypt($string = "") {

        $hash = 'md5';

        $salt = "!~ALZ875(%";

        if ($hash == "md5")
            return md5($string . $salt);
        if ($hash == "sha1")
            return sha1($string . $salt);
        else
            return hash($hash, $string . $salt);
    }

    public function isAdmin()
    {
        if (Yii::$app->user->isGuest)
            return false;
        else {
            if (User::findOne($this->id)->superuser)
                return true;
            else
                return false;
        }
    }
}