<?php

namespace app\controllers;

use Yii;

class ProfileController extends Controller
{
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


    public function actionIndex() {

        $profile = $this->loadProfile();

        return $this->render('index', array(
                'model' => $profile,
            )
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $profile = $this->loadProfile();

        // ajax validator
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'profile-form') {
            echo UActiveForm::validate(array($model, $profile));
            Yii::$app->end();
        }

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $profile->attributes = $_POST['Profile'];

            if ($model->validate() && $profile->validate()) {
                $model->save();
                $profile->save();
                Yii::$app->user->updateSession();
                Yii::$app->session->setFlash('info', Yii::t('app', "Changes is saved."));
                $this->redirect(array('/user/profile'));
            } else
                $profile->validate();
        }

        return $this->render('edit', array(
            'model' => $model,
            'profile' => $profile,
        ));
    }

    private function loadProfile()
    {
        return Yii::$app->user->identity->profile;
    }

}
