<?php

namespace app\components;

use Yii;
use app\models\User;
use yii\helpers\Url;

class WebUser extends \yii\web\User
{
    public function init()
    {
        parent::init();
        // устанавливаем homeUrl
        $this->on(static::EVENT_AFTER_LOGIN, function ($event) {
            if (Yii::$app->user->isGuest) {
                return;
            }
            switch ($this->identity->status) {
                case User::STATUS_ADMIN:
                    $hr = Url::to(['/admin/category']);
                    break;
                case User::STATUS_MODER:
                    $hr = Url::to(['/moderator']);
                    break;
                default:
                    $hr = Url::to(['/lk/adverts']);
            }
            Yii::$app->setHomeUrl($hr);
        });
    }

    public function can($permissionName, $params = [], $allowCaching = true)
    {
        /** @var \app\models\User $user */
        $user = $this->identity;
        $access = false;
        do {
            if (Yii::$app->user->isGuest) {
                break;
            }

            if ($user->status === User::STATUS_ADMIN) {
                $access = true;
                break;
            }

            if (is_array($permissionName)) {
                $access = in_array($user->status, $permissionName);
            } else {
                $access = $permissionName === $user->status;
            }
        } while (false);

        return $access;
    }

    public static function crypt($string = "", $hash = 'md5') {
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
            return $this->identity->status == User::STATUS_ADMIN;
        }
    }

    public function isModer()
    {
        if (Yii::$app->user->isGuest)
            return false;
        else {
            return $this->identity->status == User::STATUS_MODER;
        }
    }

}