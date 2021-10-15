<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Adverts;


class AdvertsController extends BackendController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'admin-template';
    public $title = 'Обьявления';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        return $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Adverts;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Adverts'])) {
            $model->attributes = $_POST['Adverts'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        return $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Adverts'])) {
            $model->attributes = $_POST['Adverts'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        return $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionModerate($id) {
        $model = $this->loadModel($id);
        $model->moderated = 1;
        if ($model->save()) {
            echo "ok";
            return true;
        }

        echo "error";
        return false;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via view grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new Adverts();

        return $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Adverts the loaded model
     */
    public function loadModel($id) {
        $model = Adverts::findOne($id);
        if ($model === null)
            throw new \yii\web\NotFoundHttpException();
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Adverts $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bulletin-form') {
            echo CActiveForm::validate($model);
            Yii::$app->end();
        }
    }

}
