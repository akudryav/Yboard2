<?php

namespace app\modules\admin\controllers;

use app\models\forms\ParamForm;
use Yii;
use app\models\Category;
use app\models\CategorySearch;

class CategoryController extends Controller
{

    public $title = 'Категории';

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->loadModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $params = [];
        $post = Yii::$app->request->post('Category');

        if (!empty($post)) {
            $model->name = $post['name'];
            $model->position = $post['position'];
            $parent_id = $post['parentId'];
            $model->fields = self::prepareValues(Yii::$app->request->post('ParamForm'));

            if (empty($parent_id))
                $model->makeRoot();
            else {
                $parent = Category::findOne($parent_id);
                $model->appendTo($parent);
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'params' => $params,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $params = [];
        if ($model->fields) {
            $model->params_flag = true;
            foreach (unserialize($model->fields) as $item) {
                $p = new ParamForm();
                $p->setAttributes($item);
                $params[] = $p;
            }
        }

        $post = Yii::$app->request->post('Category');

        if (!empty($post)) {
            $model->name = $post['name'];
            $model->position = $post['position'];
            $parent_id = $post['parentId'];
            $model->fields = self::prepareValues(Yii::$app->request->post('ParamForm'));

            if ($model->save()) {
                if (empty($parent_id)) {
                    if (!$model->isRoot())
                        $model->makeRoot();
                } else // move node to other root
                {
                    if ($model->id != $parent_id) {
                        $parent = Category::findOne($parent_id);
                        $model->appendTo($parent);
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'params' => $params,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        if ($model->isRoot())
            $model->deleteWithChildren();
        else
            $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function loadModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

    protected static function prepareValues($array)
    {
        if(empty($array)) return null;
        foreach ($array as $k => $v) {
            $values = trim($v['values']);
            $array[$k]['values'] = $values;
            if (empty($v['code'])) {
                $array[$k]['code'] = uniqid();
            }
            if (!empty($values)) {
                $tmp = explode(',', $values);
                $trimmed = array_map('trim', $tmp);
                $array[$k]['values'] = implode(',', $trimmed);
            } else {
                unset($array[$k]['values']);
            }
        }
        return serialize($array);
    }

}
