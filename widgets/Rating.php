<?php

namespace app\widgets;

use app\models\Reviews;
use yii\base\Widget;



class Rating extends Widget
{
    public $profile;
    public $chats;

    public function init() {
        $this->chats = $this->profile->isRateble();
        if($this->chats) {
            $this->registerJsFile(
                '@web/js/rater.js',
                ['depends' => [\yii\web\JqueryAsset::class]]
            );
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