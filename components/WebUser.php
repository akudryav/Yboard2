<?php

namespace app\components;

use Yii;
use yii\web\User;
use yii\helpers\Url;

class WebUser extends User
{
    public function init()
    {
        parent::init();
        // устанавливаем homeUrl
        $this->on(static::EVENT_AFTER_LOGIN, function ($event) {
            $hr = $this->isAdmin() ? Url::to(['admin/category']) : Url::to(['lk/adverts']);
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

            if ($user->status === \app\models\User::STATUS_ADMIN) {
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
            return $this->identity->status === \app\models\User::STATUS_ADMIN;
        }
    }

    public function getAvatar($size = 64)
    {
        return \cebe\gravatar\Gravatar::widget([
            'email' => $this->identity->email,
            'defaultImage' => 'identicon',
            'options' => [
                'alt' => $this->identity->username,
            ],
            'size' => $size
        ]);
    }
}