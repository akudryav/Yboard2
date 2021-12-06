<?php

namespace app\modules\moderator\controllers;

use app\models\User;

class Controller extends \yii\web\Controller
{

    public $layout = 'moderator-template';
    public $title;
    public $menu = array();

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::STATUS_MODER]
                    ]
                ]
            ]
        ];
    }

}

