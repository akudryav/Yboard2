<?php

namespace app\modules\lk\controllers;

use app\models\Adverts;
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

    /**
     * Вывод пользователей с которыми ведется переписка
     * для текущего пользователя
     */
    public function actionIndex()
    {

        $chats = Messages::find()
            ->select(['chat_id', 'MAX(advert_id) AS advert_id'])
            ->where(['or',
            ['sender_id' => Yii::$app->user->id],
            ['receiver_id' => Yii::$app->user->id],
        ])->with('advert')
            ->groupBy(['chat_id'])->all();

        return $this->render('index', array(
            'chats' => $chats,
        ));
    }


    public function actionDialog($chat_id)
    {
        $this->layout = false;
        // готовим сообщения чата
        $messages = Messages::find()->where(['or',
            ['sender_id' => Yii::$app->user->id],
            ['receiver_id' => Yii::$app->user->id],
        ])->andWhere(['chat_id' => $chat_id])
            ->with(['author', 'recipient'])->all();
        // проставляем время прочтения
        foreach($messages as $mes) {
            if($mes->read_at == 0 && $mes->receiver_id == Yii::$app->user->id) {
                $mes->updateAttributes(['read_at' => time()]);
            }
        }
        // модель для ответного сообщения
        $model = new Messages();
        $model->chat_id = $chat_id;
        if(isset($messages[0])){
            $model->advert_id = $messages[0]->advert_id;
            $model->receiver_id = ($messages[0]->sender_id == Yii::$app->user->id) ?
                $messages[0]->receiver_id : $messages[0]->sender_id;
        } else {
            $advert_id = strtok($chat_id, '_');
            $advert = Adverts::findOne($advert_id);
            $model->advert_id = $advert->id;
            $model->receiver_id = $advert->user_id;
        }

        return $this->render('dialog', array(
            'messages' => $messages,
            'userData' => $this->currentUser,
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
