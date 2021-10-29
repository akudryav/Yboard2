<?php

namespace app\controllers;

use Yii;
use app\models\Adverts;
use app\models\forms\ContactForm;
use app\models\Category;
use app\models\Location;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;


/**
 * Контролер сайта включающий отдельные возможности
 * Процедура установки
 * Форма контактов
 * Вывод дополнительных поляй для категории actionGetfields
 */
class SiteController extends Controller
{

    public function actions()
    {
        return array(
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'page' => [
                'class' => 'yii\web\ViewAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        );
    }

    /**
     * Вывод главной
     * отличается наличием виджета категорий вверху
     */
    public function actionIndex()
    {
        $roots = Category::find()->roots()->all();
        $query = Adverts::find()->where('id <> 1'); // добавить проверку moderated
        $indexAdv = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', array(
            'roots' => $roots,
            'indexAdv' => $indexAdv,
        ));
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
                Yii::$app->mailer->compose()
                    ->setFrom($user->email)
                    ->setTo(Yii::$app->params['adminEmail'])
                    ->setSubject($model->subject)
                    ->setTextBody($model->body)
                    ->send();

                Yii::$app->session->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        return $this->render('contact', array('model' => $model, 'user' => $user));
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