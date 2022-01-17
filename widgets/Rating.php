<?php

namespace app\widgets;

use app\models\Reviews;
use yii\base\Widget;
use app\assets\UserAsset;


class Rating extends Widget
{
    public $profile;
    public $chats;

    public function init() {
        $this->chats = $this->profile->isRateble();
        if($this->chats) {
            UserAsset::register($this->getView());
        }

        parent::init();
    }

    public function run()
    {
        return $this->render('rating', [
            'profile' => $this->profile,
            'model' => new Reviews(),
            'chats' => $this->chats,
        ]);
    }
}