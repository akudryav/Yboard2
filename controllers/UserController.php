<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Profile;
use app\models\Reviews;
use yii\data\ArrayDataProvider;
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
                return $this->goHome();
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
                return $this->goHome();
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

    /**
     * Пользователь с профилем
     */
    public function loadUser($id)
    {
        $model = User::findOne($id);
        if ($model === null)
            throw new \yii\web\NotFoundHttpException();
        return $model;
    }

    /**
     * Просмотре объявлений пользователя
     * @param int $id User's id
     */
    public function actionView($id)
    {
        $user = $this->loadUser($id);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $user->adverts,
        ]);

        return $this->render('view', [
            'model' => $user,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Голосование за пользователя
     */
    public function actionRating()
    {
        $this->layout = false;
        $post = Yii::$app->request->post();
        $session = Yii::$app->session;
        if (isset($post['id']) && is_numeric($post['rating'])) {
            $review = new Reviews();
            $review->profile_id = intval($post['id']);
            $review->author_id = Yii::$app->user->id;
            $review->rating = floatval($post['rating']);
            $review->message = isset($post['message']) ? $post['message'] : null;

            $profile = Profile::findOne(['user_id' => $review->profile_id]);
            $chats = $profile->isRateble();
            if (!$profile || !$chats) {
                return $this->renderContent(-1); //пользователь не найден
            }
            $review->advert_id = $chats[0]->advert_id;

            if (!isset($session['rating_ids'])) {
                $session['rating_ids'] = array();
            }

            if (!in_array($review->profile_id, $session['rating_ids'])) {
                if ($review->save()) {
                    // пересчет среднего рейтинга
                    $rate = ($profile->rating_avg * $profile->rating_count + $review->rating) / ($profile->rating_count + 1);
                    $profile->updateAttributes(['rating_avg' => $rate, 'rating_count' => $profile->rating_count + 1]);
                    $session['rating_ids'][] = $review->profile_id; // вносим в список который уже проголосовали
                    return $this->renderContent($rate);
                }
            } else return $this->renderContent(0); //уже голосовали
        }
        return $this->renderContent(-2); //неверные параметры
    }

}