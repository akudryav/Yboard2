<?php

namespace app\modules\lk\controllers;

use Yii;
use app\models\Category;
use app\models\Adverts;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\bootstrap4\Html;


class AdvertsController extends Controller
{

    public $title = 'Объявления';

    public function beforeAction($action)
    {
        $profile = $this->currentUser->profile;
        if(empty($profile) || !$profile->validate()) {
            $errors = $profile ? Html::errorSummary($profile, ['encode' => false]) :
                Yii::t('user', 'You need to fill profile');
            Yii::$app->session->setFlash('error', $errors);
            $this->redirect(['/lk/profile/update']);
            return false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        return $this->render('//adverts/view', array(
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
        $model->fields = '';

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->save() && $model->upload() &&
                $model->addParams(Yii::$app->request->post('Params'))) {
                // file is uploaded successfully
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'categories' => Category::makeOptionsList(),
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

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->save() && $model->upload() &&
                $model->addParams(Yii::$app->request->post('Params'))) {
                // file is uploaded successfully
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => Category::makeOptionsList(),
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
        $this->view->title = Yii::t('adv', 'Manage adverts');
        $dataProvider = new ActiveDataProvider([
            'query' => Adverts::find()->where(['user_id' => $this->currentUser->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'user' => $this->currentUser,
        ]);

    }

    public function actionFavorites()
    {
        $this->view->title = Yii::t('adv', 'Favorites');
        $query = Adverts::find()
            ->select('adverts.*')
            ->innerJoin('favorites', 'favorites.obj_id = adverts.id')
            ->where([
                'moderated' => 1,
                'favorites.user_id' => Yii::$app->user->id,
                'obj_type' => 0,
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionParamsForm($categ_id)
    {
        $this->layout = false;
        $form = new \yii\bootstrap4\ActiveForm();

        return $this->render('_params', [
            'params' => [],
            'category' => Category::findOne($categ_id),
            'form' => $form,
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
        $model = Adverts::find()
            ->where(['id' => $id, 'user_id' => $this->currentUser->id])
            ->with('params')->one();
        if ($model === null)
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Advert not Found'));
        return $model;
    }

}
