<?php

namespace app\modules\admin\controllers;

use app\models\User;
use Yii;


class DefaultController extends Controller
{

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */


    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function actionIndex() {



        var_dump(User::getAdmins());

        $registrations = Yii::$app->db->createCommand("select count(*) as num, DATE_FORMAT(create_at, '%d %b') as data "
                        . "from users group by DATE_FORMAT(create_at, '%Y %m %d') limit 7 ")->queryAll();
        $adverts = Yii::$app->db->createCommand("select count(*) as num, DATE_FORMAT(created_at, '%d %b') as data "
                        . "from adverts group by day(created_at) limit 7")->queryAll();
        $messages = Yii::$app->db->createCommand("select count(*) as num, DATE_FORMAT(created_at, '%d %b') as data "
                        . "from messages group by day(created_at) limit 7")->queryAll();

        //var_dump($messages->getData());

        $this->title = "Панель администратора";

        $chart[0]['data'] = "";
        $chart[0]['label'] = "";
        foreach ($registrations as $mes) {
            if ($chart[0]['data'] !== "")
                $chart[0]['data'] .= ",";
            $chart[0]['data'] .= $mes['num'];
            if ($chart[0]['label'] !== "")
                $chart[0]['label'] .= ",";
            $chart[0]['label'] .= '"' . $mes['data'] . '"';
        }
        $chart[0]['data'] = "[" . $chart[0]['data'] . "]";
        $chart[0]['label'] = "[" . $chart[0]['label'] . "]";


        $chart[1]['data'] = "";
        $chart[1]['label'] = "";
        foreach ($adverts as $mes) {
            if ($chart[1]['data'] !== "")
                $chart[1]['data'] .= ",";
            $chart[1]['data'] .= $mes['num'];

            if ($chart[1]['label'] !== "")
                $chart[1]['label'] .= ",";
            $chart[1]['label'] .= '"' . $mes['data'] . '"';
        }
        $chart[1]['data'] = "[" . $chart[1]['data'] . "]";
        $chart[1]['label'] = "[" . $chart[1]['label'] . "]";


        $chart[2]['data'] = "";
        $chart[2]['label'] = "";
        foreach ($messages as $mes) {
            if ($chart[2]['data'] !== "")
                $chart[2]['data'] .= ",";
            $chart[2]['data'] .= $mes['num'];

            if ($chart[2]['label'] !== "")
                $chart[2]['label'] .= ",";
            $chart[2]['label'] .= '"' . $mes['data'] . '"';
        }
        $chart[2]['data'] = "[" . $chart[2]['data'] . "]";
        $chart[2]['label'] = "[" . $chart[2]['label'] . "]";


        return $this->render('index', array(
            'chart' => $chart,
        ));

        /**/
    }

    public function actionHelp() {
        return $this->render('help');
    }

    public function actionSettings() {

        return $this->render('config', array('configPath' => Yii::getAlias('@config/params') . '.php'));
    }

}
