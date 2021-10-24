<?php

namespace app\modules\lk\controllers;

use app\models\Category;
use Yii;
use app\models\Adverts;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;


class AdvertsController extends Controller
{

    public $title = 'Обьявления';

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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Adverts;
        $model->user_id = $this->currentUser->id;
        $model->location = 0;
        $model->fields = '{}';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $categories = Category::find()
            ->orderBy('name')
            ->all();

        return $this->render('create', [
            'model' => $model,
            'categories' => ArrayHelper::map($categories, 'id', 'name'),
        ]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        $categories = Category::find()
            ->orderBy('name')
            ->all();

        return $this->render('update', [
            'model' => $model,
            'categories' => ArrayHelper::map($categories, 'id', 'name'),
        ]);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        $request = Yii::$app->request;
        if (!$request->isAjax) {
            $returnUrl = Yii::$app->request->referrer ?: ['index'];
            $this->redirect($returnUrl);
        }

    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Adverts::find()->where(['user_id' => $this->currentUser->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'user' => $this->currentUser,
        ]);

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Adverts the loaded model
     */
    public function loadModel($id)
    {
        $model = Adverts::findOne(['id' => $id, 'user_id' => $this->currentUser->id]);
        if ($model === null)
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Advert not Found'));
        return $model;
    }

}
