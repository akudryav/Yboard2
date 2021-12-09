<?php

namespace app\widgets;

use app\models\User;
use yii\base\Widget;

class Profile extends Widget
{
    public $advert;

    public function run()
    {
        $user = User::findOne($this->advert->user_id);

        return $this->render('profile', [
            'model' => $user,
            'advert' => $this->advert,
        ]);
    }
}