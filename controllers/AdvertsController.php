<?php
namespace app\controllers;

use Yii;
use app\components\TextValidator;
use app\models\Category;
use app\models\Messages;
use app\models\Adverts;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use zxbodya\yii2\galleryManager\GalleryManagerAction;


class AdvertsController extends DefaultController {

    public function actions() {
        return array(
            //'importAdvertss' => 'application.controllers.site.ImportAdvertssAction' ,
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array('class' => 'CCaptchaAction', 'backColor' => 0xFFFFFF,),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array('class' => 'CViewAction',),
            'galleryApi' => [
                'class' => GalleryManagerAction::className(),
                // mappings between type names and model classes (should be the same as in behaviour)
                'types' => [
                    'product' => Adverts::className()
                ]
            ],
        );
    }

    public function actionSetFavorites($id) {
        $model = Favorites::find(" user_id='" . Yii::$app->user->id
                . "' and obj_id='" . $id . "' and obj_type='0'");
        if ($model) {
            $model->delete();
            echo 'false';
        } else {
            $model = New Favorites();
            $model->user_id = Yii::$app->user->id;
            $model->obj_id = $id;
            $model->obj_type = 0;
            $model->save();
            echo 'true';
        }
    }

    public function actionFavorites() {



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
            ->join('inner join', 'users',  ' users.id=favorites.user_id ')
            ->join('inner join', 'favorites', 't.id=favorites.obj_id ')
            ->where(['user_id' => Yii::$app->user->id ]);

        $dataProvider = new ActiveDataProvider( array(
            'query' => $query
        ));


        return $this->render('index', array(
            'data' => $dataProvider,
        ));
    }


    public function actionGetfields($cat_id) {

        // Получение категории
        $model = Category::findOne($cat_id);

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

            echo '<input type="hidden" class="error" value="' . $cat_id . '" '
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

            echo Html::dropDownList('subcat_' . $cat_id, 0, $drop_cats, array('empty' => Yii::t('app', 'Choose category'), 'onchange' => 'loadFields(this)'));

            return;
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadAdverts($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Reviews'])) {
            $model->attributes = $_POST['Reviews'];
            if ($_POST['Adverts']['no_price'] === "on") {
                $model->price = 0;
            }
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        return $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {

        $query = Adverts::find()->where(['moderated' => 1])->limit(10)->orderBy('id', 'desc');

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
     * Displays the contact page
     * @param int $id User's id
     */
    public function actionCreate() {


        $model = new Adverts;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Adverts'])) {
            $model->attributes = $_POST['Adverts'];
            $model->user_id = Yii::$app->user->id;
            $model->created_at = date("Y-m-d H:i:s");
            $model->fields = serialize($_POST['Fields']);
            if ($_POST['Adverts']['no_price'] === "on") {
                $model->price = 0;
            }

            /*
            if ($model->save()) {
                $video = CUploadedFile::getInstances($model, 'youtube_id');
                //YoutubeHelper::processAdverts($model, $video);

                $images = CUploadedFile::getInstancesByName('images');
                // proceed if the images have been set
                ImagesHelper::processImages($model, $images);
                $this->redirect(array('adverts/view', 'id' => $model->id));
            }
            */
        }

        return $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Show bulletin.
     * @param int $id Adverts's id
     */
    public function actionView($id) {

        // Модель для моментального сообщения со страницы просмотра объявления
        $mes_model = new Messages();
        $model = $this->loadAdverts($id);
        $model->views++;
        $model->save();
        $model->fields = unserialize($model->fields);

        $this->meta = Yii::$app->params['adv_meta'][Yii::$app->language];
        $this->meta['vars']['cat_name'] = Yii::$app->params['categories'][$model->category_id]['name'];
        $this->meta['vars']['adv_title'] = $model->name;

        $query = Adverts::find()->where('category_id = ' . $model->category_id)
            ->where(' id != ' . $model->id)->limit(5);

        // Похожие объявления   
        $dataRel = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        
       

        
        return $this->render('view', array(
            'model' => $model,
            'mes_model' => $mes_model,
            'dataRel' => $dataRel,
        ));

    }

    /**
     * Show category.
     * @param int $cat_id Category's id
     */
    public function actionCategory($cat_id) {

        /*
        $query = \app\models\Adverts::findAllBySql("select adverts.* from adverts ".
            "where category_id ='".$cat_id."' inner join category on category.id=t.category_id ");

        $dataProvider = new ActiveDataProvider( array(
            'query' => $query
        ));
        /**/

        /*
        $count = Yii::$app->db->createCommand(' select count(t.* ) from adverts t '.
            ' inner join category on category.id=t.category_id where '.
            ' t.category_id = :id or (category.lft > :cat_lft ' .
            ' and category.rgt< :cat_rgt and category.root = :cat_root)', array(
            ':id' => (int) $cat_id,
            ':cat_lft' => Yii::$app->params['categories'][$cat_id]['lft'],
            ':cat_rgt' => Yii::$app->params['categories'][$cat_id]['rgt'],
            ':cat_root' => Yii::$app->params['categories'][$cat_id]['root'],
            ':cat_root' => Yii::$app->params['categories'][$cat_id]['root'],
        ))->queryScalar();
        /**/

        $dataProvider = new SqlDataProvider([
            'sql' => 'select t.*, IFNULL(updated_at, created_at) as sort from adverts t '.
                ' inner join category on category.id=t.category_id where '.
                ' t.category_id = :id or (category.lft > :cat_lft ' .
                ' and category.rgt< :cat_rgt and category.root = :cat_root)',
            'params' => array(
                ':id' => (int) $cat_id,
                ':cat_lft' => Yii::$app->params['categories'][$cat_id]['lft'],
                ':cat_rgt' => Yii::$app->params['categories'][$cat_id]['rgt'],
                ':cat_root' => Yii::$app->params['categories'][$cat_id]['root'],
            ),
            /*
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'title',
                    'view_count',
                    'created_at',
                ],
            ],
            /**/
        ]);

        /*
        $dataProvider = new ActiveDataProvider('Adverts', array(
            'criteria' => array(
                'select' => 't.*, IFNULL(updated_at, created_at) as sort',
                'condition' => 't.category_id = :id or (category.lft > :cat_lft '
                . 'and category.rgt< :cat_rgt and category.root = :cat_root)',
                'order' => 'sort DESC',
                'params' => array(
                    ':id' => (int) $cat_id,
                    ':cat_lft' => Yii::$app->params['categories'][$cat_id]['lft'],
                    ':cat_rgt' => Yii::$app->params['categories'][$cat_id]['rgt'],
                    ':cat_root' => Yii::$app->params['categories'][$cat_id]['root'],
                    ':cat_root' => Yii::$app->params['categories'][$cat_id]['root'],
                ),
                'limit' => Yii::$app->params['adv_on_page'],
                'join' => 'inner join category on category.id=t.category_id ',
            ),
        ));
        */

        $this->meta['vars']['cat_name'] = Yii::$app->params['categories'][$cat_id]['name'];

        return $this->render('category', array(
            'model' => $this->loadCategory($cat_id),
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Show category.
     * @param int $id User's id
     */
    public function actionUser($id = 0 ) {


        $query = Adverts::find()->where(['user_id' => $id])->orderBy('sort', 'desc');

        $dataProvider = new ActiveDataProvider('Adverts', array(
            'query' =>$query,
        ));

        return $this->render('index', array(
            //'model'=>$this->loadCategory($cat_id),
            'data' => $dataProvider,
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
