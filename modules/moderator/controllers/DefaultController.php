<?php

namespace app\modules\moderator\controllers;

use Yii;
use app\models\Adverts;
use app\models\AdvertsSearch;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->renderList();
    }

    public function actionModerate($id)
    {
        $this->layout = false;
        $model = $this->loadModel($id);
        $model->moderated = Yii::$app->request->get('res', 0);
        if ($model->save()) {
            return $this->renderList();
        }

        return $this->renderContent('error');
    }

    public function loadModel($id) {
        $model = Adverts::findOne($id);
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException();
        }

        return $model;
    }

    protected function renderList()
    {
        $searchModel = new AdvertsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $method = Yii::$app->request->isAjax ? 'renderAjax' : 'render';

        return $this->$method('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
