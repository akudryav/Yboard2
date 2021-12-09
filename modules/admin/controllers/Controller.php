<?php

namespace app\modules\admin\controllers;

use app\models\User;

class Controller extends \yii\web\Controller
{

    public $layout = '/admin';
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
                        'roles' => [User::STATUS_ADMIN]
                    ]
                ]
            ]
        ];
    }

}

