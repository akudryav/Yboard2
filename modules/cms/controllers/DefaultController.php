<?php
use app\models\User;

class DefaultController extends yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'status' => [User::STATUS_ADMIN]
                    ]
                ]
            ]
        ];
    }

}
