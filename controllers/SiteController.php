<?php

namespace app\controllers;

use app\models\forms\LoginForm;
use Yii;
use app\models\Adverts;
use app\models\forms\ContactForm;
use app\models\Category;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use rmrevin\yii\ulogin\AuthAction;


/**
 * Контролер сайта включающий отдельные возможности
 * Процедура установки
 * Форма контактов
 * Вывод дополнительных поляй для категории actionGetfields
 */
class SiteController extends DefaultController
{

    public function actions()
    {
        return array(
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'page' => array(
                'class' => 'CViewAction',
            ),
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

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform actions
                'actions' => array('index', 'error', 'contact', 'bulletin', 'category', 'captcha', 'page', 'advertisement', 'getfields', 'search'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user
                'actions' => array('create'),
                'users' => array('@'),
            ),
            array('allow', // allow view user
                'actions' => array('importUsers', 'importBulletins'),
                'users' => array('view'),
            ),
        );
    }

    /**
     * Вывод главной
     * отличается наличием виджета категорий вверху
     */
    public function actionIndex()
    {
        $roots = Category::find()->roots()->all();


        // $query = (new Query())->from('post')->where(['status' => 1]);
        $query = Adverts::find()->where('id <> 1');


        // Articles on main page


        $this->indexAdv = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        /**/


        Yii::$app->view->params['indexAdv'] = $this->indexAdv;

        return $this->render('index', array(
            'roots' => $roots,
        ));
        /**/
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {

        if (Yii::$app->user->isGuest) {

            $model = new LoginForm();
            $model->load(Yii::$app->request->post());
            // collect user input data
            if ($model->login()) {
                return $this->goBack();
            }


            // display the login form
            return $this->render('/user/login', array('model' => $model));
        } else
            $this->redirect(array("site/index"));
    }

    public function uloginSuccessCallback($attributes)
    {
        print_r($attributes);
        /*if (isset($_POST['token'])) {
            $ulogin = new UloginModel();
            $ulogin->setAttributes($_POST);
            $ulogin->getAuthData();

            if ($ulogin->validate() && $ulogin->login()) {
                $this->redirect(Yii::$app->user->returnUrl);
            } else {

                return $this->render('error', array('errors' => $ulogin->errors));
            }
        } else {
            $this->redirect(Yii::$app->homeUrl);
        }*/
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->redirect(Yii::$app->homeUrl);
    }

    public function actionAbout()
    {
        return $this->render('pages/about');
    }

    /**
     * Displays the contact page
     * @param int $id User's id
     */
    public function actionContact($id = null)
    {
        $user = $id ? $this->loadUser($id) : null;
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-type: text/plain; charset=UTF-8";
                $mail = $user ? $user->email : Yii::$app->params['adminEmail'];

                mail($mail, $subject, $model->body, $headers);
                Yii::$app->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        return $this->render('contact', array('model' => $model, 'user' => $user));
    }

    public function actionView($id)
    {
        $model = $this->loadAdvert($id);
        $model->views++;
        $model->save();
        return $this->render('bulletin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     */
    public function loadAdvert($id)
    {
        $model = loadAdvert::findOne($id);
        if ($model === null)
            throw new \yii\web\NotFoundHttpException();
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     */
    public function loadCategory($id)
    {
        $model = Category::findOne($id);
        if ($model === null)
            throw new \yii\web\NotFoundHttpException();
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     */
    public function loadUser($id)
    {
        $model = User::findOne($id);
        if ($model === null)
            throw new \yii\web\NotFoundHttpException();
        return $model;
    }

    public function getBaseSitePageList()
    {

        $list = array(
            array(
                'loc' => Yii::$app->createAbsoluteUrl('/'),
                'frequency' => 'weekly',
                'priority' => '1',
            ),
            array(
                'loc' => Yii::$app->createAbsoluteUrl('/site/contact'),
                'frequency' => 'yearly',
                'priority' => '0.8',
            ),
            array(
                'loc' => Yii::$app->createAbsoluteUrl('/site/page', array('view' => 'about')),
                'frequency' => 'monthly',
                'priority' => '0.8',
            ),
            array(
                'loc' => Yii::$app->createAbsoluteUrl('/site/page', array('view' => 'privacy')),
                'frequency' => 'yearly',
                'priority' => '0.3',
            ),
        );
        return $list;
    }

    public function actionLocation_list($term)
    {
        if ($term) {
            echo json_encode(Location::CitiesSuggest($term));
        } else {
            return false;
        }
    }

    public function actionGetRegions($id = "")
    {
        if ($id) {
            echo Html::dropDownList('selectRegions', "", Location::Regions($id), array(
                "onchange" => "getCityList()",
                "class" => "form-control",
                "empty" => Yii::t('app', "Select region"),
            ));
        } else {
            return false;
        }
    }

    public function actionGetCities($id = "")
    {
        if ($id) {
            echo Html::dropDownList('selectCities', "", Location::Cities($id), array(
                "onchange" => "locationSelect()",
                "class" => "form-control",
                "empty" => Yii::t('app', "Select city")
            ));
        } else {
            return false;
        }
    }

}