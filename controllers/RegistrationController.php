<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use app\models\forms\RegistrationForm;

class RegistrationController extends DefaultController {

    public $defaultAction = 'registration';

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        );
    }

    /**
     * Registration user
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('/user/registration', [
            'model' => $model,
        ]);
    }

    public function actionActivation() {
        $email = $_GET['email'];
        $activkey = $_GET['activkey'];
        if ($email && $activkey) {
            $find = User::notsafe()->findByAttributes(array('email' => $email));
            if (isset($find) && $find->status) {
                return $this->render('/user/message', array(
                        'title' => Yii::t('app', "User activation"),
                        'content' => Yii::t('app', "You account is active.")
                    )
                );
            } elseif (isset($find->activkey) && ($find->activkey == $activkey)) {
                $find->activkey = Yii::$app->user->crypt(microtime());
                $find->status = 1;
                $find->save();
                return $this->render('/user/' . $find->id, array(
                    'title' => Yii::t('app', "User activation"),
                    'content' => Yii::t('app', "You account is activated.")
                ));
            } else {
                return $this->render('/user/message', array(
                    'title' => Yii::t('app', "User activation"),
                    'content' => Yii::t('app', "Incorrect activation URL.")
                ));
            }
        } else {
            return $this->render('/user/message', array(
                'title' => Yii::t('app', "User activation"),
                'content' => Yii::t('app', "Incorrect activation URL.")
            ));
        }
    }

}
