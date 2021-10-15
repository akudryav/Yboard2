<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Messages;
use app\models\User;

class UserController extends DefaultController {

    /**
     * @var ActiveRecord the currently loaded data model instance.
     */
    private $_model;


    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('update'),
                'expression' => 'Yii::$app->user->id == Yii::$app->request->getParam("id")',
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('*'),
                'expression' => 'Yii::$app->user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     */
    public function actionView($id) {

        $mes_model = new Messages();

        //$model=User::findOne($id);
        //echo Yii::$app->request->getParam('id');

        $model = $this->loadUser($id);
        return $this->render('view', array(
            'model' => $model,
            'mes_model' => $mes_model,
        ));
        /**/
    }



    /**
     * Lists all models.
     */
    public function actionIndex() {


        $query = User::find()->where(['status', '>', User::STATUS_BANNED]);

        $dataProvider = new ActiveDataProvider('User', array(
            'query' => $query,
            'pagination' => array(
                'pageSize' => Yii::$app->controller->module->user_page_size,
            ),
        ));

        return $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel() {
        if ($this->_model === null) {
            if (isset($_GET['id']))
                $this->_model = User::findOne($_GET['id']);
            if ($this->_model === null)
                throw new \yii\web\NotFoundHttpException();
        }
        return $this->_model;
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if (!$model->status)
                $model->status = 1;
            if (!$model->superuser)
                $model->superuser = 0;

            $model->validate();

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            } else {
                var_dump($model->getErrors());
            }
        }

        return $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionBan($id) {
        $model = $this->loadModel($id);
        $model->status = USER::STATUS_BANNED;
        $model->update(array('status'));

        //$adv_model = new Adverts();
        $adv_model = Adverts::find("user_id = :id ", array(':id' => intval($id)));
        if ($adv_model) {
            $adv_model->delete();
        }
        $this->redirect(array('/'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadUser($id = null) {
        if ($this->_model === null) {
            if ($id !== null || isset($_GET['id']))
                $this->_model = User::findOne($id !== null ? $id : $_GET['id']);
            if ($this->_model === null)
                throw new \yii\web\NotFoundHttpException();
        }
        return $this->_model;
    }

}
