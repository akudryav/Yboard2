<?php

namespace app\modules\lk\controllers;
use Yii;

class Controller extends \yii\web\Controller
{
    public $currentUser = false;

    public function init()
    {
        parent::init();
        $this->currentUser = Yii::$app->user->identity;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }
}