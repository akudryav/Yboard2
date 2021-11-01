<?php

namespace app\modules\lk\controllers;

use Yii;
use app\models\Category;
use app\models\Adverts;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


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
        $model->fields = '';

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->save() && $model->upload()) {
                // file is uploaded successfully
                return $this->redirect(['index']);
            }

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

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->save() && $model->upload()) {
                // file is uploaded successfully
                return $this->redirect(['index']);
            }
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

    public function actionFavorites()
    {
        $query = Post::find()->where(['status' => 1]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'title' => SORT_ASC,
                ]
            ],
        ]);


        $query = Adverts::find()->where(['user_id' => Yii::$app->user->id])
            ->join('inner join', 'users', ' users.id=favorites.user_id ')
            ->join('inner join', 'favorites', 't.id=favorites.obj_id ')
            ->where(['user_id' => Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);


        return $this->render('index', array(
            'data' => $dataProvider,
        ));
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
