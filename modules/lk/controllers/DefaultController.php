<?php

namespace app\modules\admin\controllers;

use app\models\User;
use Yii;


class DefaultController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

}
