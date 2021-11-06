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

    public function actionGetfields($id)
    {

        // Получение категории
        $model = Category::findOne($id);

        // Проверка есть ли дочерние 
        if ($model->lft + 1 == $model->rgt) {

            echo "<div id='fields_list'>";


            $fields = json_decode($model->fields);


            if( $fields !== null and sizeof($fields) > 0) {
                foreach ($fields as $f_iden => $fv) {
                    ?>
                    <div class="controls">
                        <label for='Fields[<?= $f_iden ?>]'><?= $fv->name ?></label>
                        <?php if ($fv->type == 1) { ?>
                            <input type="checkbox" id="Fields[<?= $f_iden ?>]"
                                   name="Fields[<?= $f_iden ?>]" <?php ($fv->atr ? "checked='checked'" : "") ?> >
                            <?php                         } elseif ($fv->type == 2) {
                            echo Html::dropDownList("Fields[" . $f_iden . "]", array()
                                , explode(",", $fv->atr));
                        } else {
                            ?>
                            <input type="text" id="Fields[<?= $f_iden ?>]" name="Fields[<?= $f_iden ?>]">
                        <?php } ?>
                    </div>

                    <?php                 }
            }

            echo "</div>";

            echo '<input type="hidden" class="error" value="' . $id . '" '
                . 'id="Adverts_category_id" name="Adverts[category_id]">';
        } else {
            // Вывод дочерних категории
            $subcat = Yii::$app->db->createCommand('select id,name  from category  '
                            . 'where root=' . $model->root . ' and lft>' . $model->lft . ' '
                            . 'and rgt<' . $model->rgt . ' and level=' . ($model->level + 1) . ' ')->query();



            $drop_cats = array();

            foreach ($subcat as $cat) {

                $drop_cats[$cat['id']] = $cat['name'];
            }

            echo Html::dropDownList('subcat_' . $id, 0, $drop_cats, array('empty' => Yii::t('app', 'Choose category'), 'onchange' => 'loadFields(this)'));

            return;
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

        if (Yii::$app->request->get('Adverts_page')) {
            Yii::$app->params['meta']['vars']['page_number'] = Yii::$app->request->get('Adverts_page');
        }

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
        $this->meta['vars']['cat_name'] = Yii::$app->params['categories'][$model->category_id]['name'];
        $this->meta['vars']['adv_title'] = $model->name;

        $query = Adverts::find()->where(['<>', 'id', $model->id])
            ->andWhere(['category_id' => $model->category_id])
            ->orderBy('RAND()')->limit(5);

        // Похожие объявления   
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
                    ['>', 'category.lft', Yii::$app->params['categories'][$id]['lft']],
                    ['<', 'category.rgt', Yii::$app->params['categories'][$id]['rgt']],
                    ['category.root' => Yii::$app->params['categories'][$id]['root']]
                ]
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->meta['vars']['cat_name'] = Yii::$app->params['categories'][$id]['name'];

        return $this->render('category', array(
            'model' => $this->loadCategory($id),
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Show Advertisement.
     * @param int $id Advertisement's id
     */
    public function actionAdvertisement($id) {
        $model = $this->loadAdvertisement($id);
        return $this->render('advertisement', array(
            'model' => $model,
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
    public function loadAdvertisement($id) {
        $model = Advertisement::findOne($id);
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
        $results = true;

        if ($searchStr) {
            $model->name = $searchStr;
            $model->text = $searchStr;
        }


        $model->category_id = Yii::$app->request->get("cat_id");
        $model->location = Yii::$app->request->get("Adverts");
        $model->location = $model->location['location'];
        $model->price_min = Yii::$app->request->get("Adverts");
        $model->price_min = $model->price_min['price_min'];
        $model->price_max = Yii::$app->request->get("Adverts");
        $model->price_max = $model->price_max['price_max'];

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
            'data' => $dataProvider, 'results' => $results
        ));
    }

}
