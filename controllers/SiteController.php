<?php

namespace app\controllers;

use app\models\UserLogin;
use Yii;
use app\models\Adverts;
use app\models\InstallForm;
use app\models\ContactForm;
use app\models\Category;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\models\ConfigForm;
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
        if (is_file(Yii::getAlias('@config/install'))) {
            //------------------- Start install------------------
            return $this->redirect("site/install");
        }

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

            $model = new UserLogin();
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

    public function actionInstall()
    {

        $config_path = Yii::getAlias('@config/main_conf') . '.php'; // Путь к файлу конфигурации для его изменения
        $this->layout = "install-layout";
        $db_error = false;
        $error = false;
        $model = new InstallForm();

        if (is_file(dirname($config_path) . "/install")) {


            if (!is_writable($config_path)) {
                $model->addError("site_name", "Файл " . $config_path . " должен быть доступен для записи");
            }

            if (!is_writable(Yii::getAlias('@config/params') . ".php")) {
                $model->addError("site_name", "Файл "
                    . Yii::getAlias('@config/params') . ".php"
                    . " должен быть доступен для записи");
            }

            if (!is_writable(Yii::getAlias('@runtime'))) {
                $model->addError("site_name", "папка "
                    . Yii::getAlias('@runtime')
                    . " должена быть доступена для записи");
            }


            if (!is_writable(Yii::$app->basePath . "/assets")) {
                $model->addError("site_name", "папка /assets должена быть доступена для записи");
            }

            if (ini_get("short_open_tag") === "Off" or !ini_get("short_open_tag")) {
                $error = Yii::t('app', "Your configuration requires changes.") . Yii::t('app', "
short_open_tag option must be enabled in the php.ini or another method available");
            }


            if ($model->load(Yii::$app->request->post()) && $model->validate() && !$error) {
                // данные Mysql
                $server = trim(stripslashes($_POST['InstallForm']['mysql_server']));
                $username = trim(stripslashes($_POST['InstallForm']['mysql_login']));
                $password = trim(stripslashes($_POST['InstallForm']['mysql_password']));
                $db_name = trim(stripslashes($_POST['InstallForm']['mysql_db_name']));

                if (!$model->errors) {
                    $db_con = mysqli_connect($server, $username, $password) or $db_error = mysqli_error();
                    mysqli_set_charset($db_con, "utf8");
                    mysqli_select_db($db_con, $db_name) or $db_error = mysqli_error($db_con);
                }

                if (!$db_error and !$model->errors) {
                    $config_data = require $config_path;

                    $dump_file = file_get_contents(Yii::getAlias('@app/data/install') . '.sql');

                    // Сохранение данных о пользователе 
                    $dump_file .= " INSERT INTO `users` 
                                    (`username`, `password`, `email`, `activkey`, `superuser`, `status`)     VALUES "
                        . "('" . $model->username . "', '" . Yii::$app->user->crypt($model->userpass) . "', "
                        . "'" . $model->useremail . "', '" . Yii::$app->user->crypt(microtime() . $model->userpass) . "',"
                        . " 2, 1);";

                    mysqli_multi_query($db_con, $dump_file) or $db_error = mysqli_error($db_con);

                    if (!$db_error) {
                        // Заполнение конфигурации
                        $config_data['components']['db'] = array(
                            'class' => 'yii\db\Connection',
                            'dsn' => 'mysql:host=' . $server . ';dbname=' . $db_name,
                            'emulatePrepare' => true,
                            'username' => $username,
                            'password' => $password,
                            'charset' => 'utf8',
                            'tablePrefix' => '',
                        );
                        $config_data['name'] = trim(stripslashes($_POST['InstallForm']['site_name']));
                        $config_data['params'] = "require";

                        $config_array_str = var_export($config_data, true);
                        $config_array_str = str_replace("'params' => 'require',", "'params' => require 'params.php',", $config_array_str);
                        //Сохранение конфигурации 
                        file_put_contents($config_path, "<?php return " . $config_array_str . " ?>");

                        // Сохранение настроек
                        $settings = new ConfigForm(Yii::getAlias('@config/params') . ".php");
                        $settings->updateParam('adminEmail', $model->useremail);
                        $settings->saveToFile();

                        unlink(dirname($config_path) . "/install");

                        $this->redirect(array('site/index'));
                    }
                }
            }


            return $this->render('install', array('model' => $model, 'db_error' => $db_error, 'error' => $error));


        } else {
            $this->redirect(array('site/index'));
        }
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