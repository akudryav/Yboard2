<?php

namespace app\modules\lk\controllers;

use Yii;
use app\models\Category;
use app\models\Adverts;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\bootstrap4\Html;


class CategoryController extends Controller
{
    // список доп полей для категории
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

    // список дочерних категорий
    public function actionCatList($id)
    {
        $this->layout = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $root = Category::findOne($id);
        $children = $root->children(1)->all();

        return ArrayHelper::map($children, 'id', 'name');
    }
}