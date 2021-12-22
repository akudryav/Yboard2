<?php
namespace app\controllers;

use app\models\AdvertsSearch;
use Yii;
use app\components\TextValidator;
use app\models\Category;
use app\models\Favorites;
use app\models\Adverts;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;


class AdvertsController extends Controller
{
    public function actionFavorites($id)
    {
        $this->layout = false;
        $model = Favorites::find()->where([
            'user_id' => Yii::$app->user->id,
            'obj_id' => $id,
            'obj_type' => 0,
        ])->one();

        if ($model) {
            $model->delete();
            return $this->renderContent('false');
        } else {
            $model = new Favorites();
            $model->user_id = Yii::$app->user->id;
            $model->obj_id = $id;
            $model->obj_type = 0;
            $model->save();
            return $this->renderContent('true');
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {

        $query = Adverts::find()->where(['moderated' => 1])->limit(10)->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
                'query' => $query
        ]);

        return $this->render('index', array(
            'data' => $dataProvider,
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::$app->errorHandler->error) {
            if (Yii::$app->request->isAjaxRequest)
                echo $error['message'];
            else
                return $this->render('error', $error);
        }
    }

    /**
     * Show bulletin.
     * @param int $id Adverts's id
     */
    public function actionView($id) {

        $model = $this->loadAdverts($id);
        $model->views++;
        $model->save();

        $this->meta = Yii::$app->params['adv_meta'][Yii::$app->language];
        $this->meta['vars']['cat_name'] = Category::getTree()[$model->category_id]['name'];
        $this->meta['vars']['adv_title'] = $model->name;
        // Походие объявления (та же категория)
        $query = Adverts::find()->where(['<>', 'id', $model->id])
            ->andWhere(['category_id' => $model->category_id])
            ->orderBy('RAND()')->limit(5);

        $dataRel = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        return $this->render('view', array(
            'model' => $model,
            'dataRel' => $dataRel,
        ));

    }

    /**
     * Show category.
     * @param int $id Category's id
     */
    public function actionCategory($id)
    {

        $query = Adverts::find()->innerJoinWith('category')
            ->where(['moderated' => 1])
            ->andWhere(['OR',
                ['category_id' => (int)$id],
                ['AND',
                    ['>', 'category.lft', Category::getTree()[$id]['lft']],
                    ['<', 'category.rgt', Category::getTree()[$id]['rgt']],
                    ['category.tree' => Category::getTree()[$id]['tree']]
                ]
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->meta['vars']['cat_name'] = Category::getTree()[$id]['name'];

        return $this->render('category', array(
            'model' => $this->loadCategory($id),
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     */
    public function loadAdverts($id) {
        $model = Adverts::findOne($id);
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException();
        }

        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     */
    public function loadCategory($id) {
        $model = Category::findOne($id);
        if ($model === null)
            throw new \yii\web\NotFoundHttpException();
        return $model;
    }

    public function actionSearch($searchStr = "") {
        $model = new AdvertsSearch();

        if ($searchStr) {
            $model->name = $searchStr;
        }
        $params = Yii::$app->request->queryParams;

        $dataProvider = $model->search($params);

        return $this->render('index', array(
            'data' => $dataProvider,
        ));
    }

}
