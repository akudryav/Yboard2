<?php

namespace app\modules\lk\controllers;

use Yii;
use yii\web\UploadedFile;


class ProfileController extends Controller
{

    public function actionIndex()
    {
        $model = $this->currentUser->profile;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Changes are saved.'));
        }

        return $this->render('index', ['model' => $model]);
    }

}
