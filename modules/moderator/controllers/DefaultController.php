<?php

namespace app\modules\moderator\controllers;

use app\models\Adverts;


class DefaultController extends Controller
{
    public function actionIndex()
    {
        $model = new Adverts(['scenario' => 'search']);
        $dataProvider = $model->search();

        return $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));

    }

    public function actionModerate($id)
    {
        $model = $this->loadModel($id);
        $model->moderated = 1;
        if ($model->save()) {
            echo "ok";
            return true;
        }

        echo "error";
        return false;
    }


}
