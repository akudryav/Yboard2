<?php
namespace app\components;

use Yii;
use app\models\User;
use app\models\Profile;

class UloginUserIdentity
{

    public function authenticate($uloginModel = null)
    {
        $user = User::findByUsername($uloginModel->email);

        if (null == $user) {
            $user = new User();
            $user->email = $uloginModel->email;
            $user->username = $uloginModel->uid;
            $pass = Yii::$app->security->generateRandomString();
            $user->setPassword($pass);
            $user->generateAuthKey();

            if($user->save())
            {
                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->first_name = $uloginModel->first_name;
                $profile->last_name = $uloginModel->last_name;
                $profile->country = $uloginModel->country;
                $profile->phone = $uloginModel->phone;
                $profile->network = $uloginModel->network;
                $profile->uid = $uloginModel->uid;
                $profile->birthdate = (string)strtotime($uloginModel->bdate);
                $profile->save();
            }

        }
        return $user;
    }

}
