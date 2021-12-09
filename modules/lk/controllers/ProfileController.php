<?php

namespace app\modules\lk\controllers;

use Yii;
use app\models\Profile;

class ProfileController extends Controller
{

    public function actionIndex() {

        $model = $this->loadProfile();

        return $this->render('index', ['model' => $model]);
    }

    public function actionUpdate()
    {
        $model = $this->loadProfile();
        if(!$model)
        {
            $model = new Profile();
            $model->user_id = $this->currentUser->id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Changes are saved.'));
            return $this->redirect('index');
        }

        return $this->render('update', ['model' => $model]);
    }


    private function loadProfile()
    {
        return $this->currentUser->profile;
    }

}
