<?php
namespace app\controllers;

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
        // Другие объявления продавца
        $query = Adverts::find()->where(['<>', 'id', $model->id])
            ->andWhere(['user_id' => $model->user_id]);

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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     */
    public function loadUser($id) {
        $model = User::findOne($id);
        if ($model === null)
            throw new \yii\web\NotFoundHttpException();
        return $model;
    }

    public function actionSearch($searchStr = "") {
        $model = new Adverts(['scenario' => 'search']);

        if ($searchStr) {
            $model->name = $searchStr;
            $model->text = $searchStr;
        }
        $params = Yii::$app->request->get("Adverts");

        $model->category_id = Yii::$app->request->get("cat_id");
        $model->moderated = Adverts::STATUS_PUBLISHED;
        $model->location = $params['location'];
        $model->price_min = $params['price_min'];
        $model->price_max = $params['price_max'];

        // Обработка дополнительных полей для поиска 
        $s_fields = $_GET['fields'];

        $txt_vld = new TextValidator();

        if (is_array($s_fields)) {
            ksort($s_fields);
            foreach ($s_fields as $fn => $fv) {
                if ($fv !== "") {
                    if ($txt_vld->validate_str($fv) and $txt_vld->validate_str($fn)) {
                        if ($model->fields) {
                            $model->fields .= "%";
                        }
                        $model->fields .= '"' . $fn . '"[^"]+"' . $fv . '"';
                    } else {
                        throw new yii\web\BadRequestHttpException(' Bad Request ');
                    }
                }
            }
        }

        $dataProvider = $model->search();

        return $this->render('index', array(
            'data' => $dataProvider,
        ));
    }

}
