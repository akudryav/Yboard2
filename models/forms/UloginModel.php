<?php
namespace app\models\forms;

use Yii;
use app\components\UloginUserIdentity;

class UloginModel extends \yii\base\Model
{
    public $uid;
    public $network;
    public $email;
    public $last_name;
    public $first_name;
    public $country;
    public $phone;
    public $bdate;

    public function rules() {
        return [
            [['uid', 'network', 'email', 'last_name', 'first_name'], 'required'],
            ['email', 'email'],
            [['country', 'phone', 'bdate'], 'string'],
        ];
    }

    public function attributeLabels() {
        return array(
            'network' => 'Сервис',
            'uid' => 'Идентификатор сервиса',
            'email' => 'eMail',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
        );
    }

    public function login() {
        $identity = new UloginUserIdentity();
        $user = $identity->authenticate($this);
        if ($user) {
            $duration = 3600 * 24 * 30;
            Yii::$app->user->login($user, $duration);
            return true;
        }
        return false;
    }

}
