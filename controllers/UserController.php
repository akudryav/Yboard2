<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\forms\RegistrationForm;
use app\models\forms\UserChangePassword;
use app\models\forms\UserRecoveryForm;
use app\models\forms\LoginForm;
use app\models\forms\UloginModel;
use rmrevin\yii\ulogin\AuthAction;


/**
 * Контролер действий с пользователем
 */
class UserController extends Controller
{

    public function actions()
    {
        return array(
            'ulogin' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'uloginSuccessCallback'],
                'errorCallback' => function ($data) {
                    \Yii::error($data['error']);
                },
            ]
        );
    }

    public function beforeAction($action)
    {
        if ($action->id == 'ulogin') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect(["site/index"]);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                return $this->goBack();
            }
        }

        // display the login form
        return $this->render('login', ['model' => $model]);

    }

    public function uloginSuccessCallback($attributes)
    {
        if (!empty($attributes)) {
            $ulogin = new UloginModel();
            $ulogin->load($attributes, '');
            if ($ulogin->validate() && $ulogin->login()) {
                $this->redirect(Yii::$app->user->returnUrl);
            } else {
                return $this->render('/site/error', array('message' => implode("\n",$ulogin->errors)));
            }
        } else {
            $this->redirect(Yii::$app->homeUrl);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->redirect(Yii::$app->homeUrl);
    }

    /**
     * Registration user
     */
    public function actionRegistration()
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

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    public function actionActivation() {
        $email = $_GET['email'];
        $activkey = $_GET['activkey'];
        if ($email && $activkey) {
            $user = User::notsafe()->findByAttributes(array('email' => $email));
            if (isset($user) && $user->status) {
                return $this->render('message', array(
                        'title' => Yii::t('app', "User activation"),
                        'content' => Yii::t('app', "You account is active.")
                    )
                );
            } elseif (isset($user->activkey) && ($user->activkey == $activkey)) {
                $user->activkey = Yii::$app->user->crypt(microtime());
                $user->status = 1;
                $user->save();
                return $this->render('message', array(
                    'title' => Yii::t('app', "User activation"),
                    'content' => Yii::t('app', "You account is activated.")
                ));
            } else {
                return $this->render('message', array(
                    'title' => Yii::t('app', "User activation"),
                    'content' => Yii::t('app', "Incorrect activation URL.")
                ));
            }
        } else {
            return $this->render('message', array(
                'title' => Yii::t('app', "User activation"),
                'content' => Yii::t('app', "Incorrect activation URL.")
            ));
        }
    }

    /**
     * Recovery password
     */
    public function actionRecovery()
    {
        $request = Yii::$app->request;
        if (Yii::$app->user->id) {
            return $this->goHome();
        }
        $token = $request->get('token');
        if ($token) {
            $form = new UserChangePassword();
            $user = User::findUserByPasswordToken($token);
            if ($user) {
                if ($form->load($request->post()) && $form->process($user)) {
                    Yii::$app->session->setFlash('success', Yii::t('user', 'New password is saved.'));
                    return $this->goHome();
                }
                return $this->render('changepassword', array('model' => $form));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('user', 'Incorrect recovery link.'));
                $this->redirect('recovery');
            }
        } else {
            $form = new UserRecoveryForm();
            if ($form->load(Yii::$app->request->post())) {
                if ($form->process()) {
                    Yii::$app->session->setFlash('success', Yii::t('user', "Please check your email. An instructions was sent to your email address."));
                    return $this->refresh();
                }
            }
            return $this->render('recovery', array('model' => $form));
        }
    }

}