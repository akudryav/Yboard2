<?php

namespace app\modules\lk\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use app\models\Messages;
use app\models\User;
use yii\data\ArrayDataProvider;

class MessagesController extends Controller
{

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        return $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionDialog($id)
    {
        $model = new Messages;

        $query = Messages::find()->where(['or',
            ['and', ['sender_id' => $id, 'receiver_id' => Yii::$app->user->id]],
            ['and', ['sender_id' => Yii::$app->user->id, 'receiver_id' => $id]]
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $userData = User::findOne($id);

        return $this->render('dialog', array(
            'dataProvider' => $dataProvider,
            'userData' => $userData,
            'model' => $model,
        ));
    }

    public function actionValidate()
    {
        $model = new Messages();
        $request = Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionSave($id = null)
    {
        if ((int)$id) {
            $model = $this->loadModel($id);
        } else {
            $model = new Messages();
        }

        $request = Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            $model->sender_id = Yii::$app->user->id;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => $model->save()];
        }

    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via view grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
    }

    /**
     * Вывод пользователей с которыми ведется переписка
     * для текущего пользователя
     */
    public function actionIndex()
    {

        $query = Messages::find()->where(['or',
            ['sender_id' => Yii::$app->user->id, 'receiver_id' => Yii::$app->user->id],
        ])->with('advert');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array(
                'pageSize' => 10,
            ),

        ]);

        return $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Messages the loaded model
     */
    public function loadModel($id)
    {
        $model = Messages::findOne($id);
        if ($model === null ||
            ($model->sender_id != Yii::$app->user->id && $model->receiver_id != Yii::$app->user->id))
            throw new \yii\web\NotFoundHttpException();
        return $model;
    }

}
