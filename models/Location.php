<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "adverts".
 *
 * The followings are the available columns in table 'bulletin':
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $category_id
 * @property boolean $type
 * @property integer $views
 * @property string $text
 */
class Location extends \yii\db\ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'sxgeo_cities';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array();
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array();
    }

    static function geoDetect()
    {

        $geo = new \jisoft\sypexgeo\Sypexgeo();
        $cookies = Yii::$app->request->cookies;
        // get by remote IP
        if (!$cookies['location_id']->value or !$cookies['location_name']->value) {

            $geo->get(Yii::$app->request->getUserIP());

            $loc['id'] = $geo->city['id'];
            $loc['name'] = $geo->city['name_ru'];
            $loc['alt'] = $geo->city['name_en'];
            $loc['reg_type'] = 2;

            /*
              elseif($geo->region['name_ru']) {
              $loc['id']=$geo->region['id'];
              $loc['name']=$geo->region['name_ru'];
              $loc['alt']=$geo->city['name_en'];
              $loc['reg_type']=1;
              } elseif($geo->country['name_ru']) {
              $loc['id']=$geo->country['id'];
              $loc['name']=$geo->country['name_ru'];
              $loc['alt']=$geo->city['name_en'];
              $loc['reg_type']=0;
              }

              else {
              $loc['id']=524901;
              $loc['name']="Москва";
              $loc['alt']="Moscow";
              $loc['reg_type']=2;
              }
             * 
             * 
             */
            $cookies = Yii::$app->response->cookies;
            $cookies->add(new \yii\web\Cookie(['name' => 'location_id', 'value' => $loc['id']]));
            $cookies->add(new \yii\web\Cookie(['name' => 'location_name', 'value' => $loc['name']]));
            $cookies->add(new \yii\web\Cookie(['name' => 'location_alt', 'value' => $loc['alt']]));
            $cookies->add(new \yii\web\Cookie(['name' => 'location_type', 'value' => $loc['reg_type']]));
        } else {
            $loc['id'] = $cookies['location_id']->value;
            $loc['name'] = $cookies['location_name']->value;
            $loc['alt'] = $cookies['location_alt']->value;
            $loc['reg_type'] = $cookies['location_type']->value;
        }

        return $loc;
    }

    static function Country() {
        $country = Yii::$app->db->createCommand("select iso, name_ru "
            . "from sxgeo_country where approved!=0 order by approved asc")->queryAll();
        return ArrayHelper::map($country, 'iso', 'name_ru');
    }

    static function Regions($id = "") {
        if ($id) {
            $regions = Yii::$app->db->
            createCommand("select id, name_ru "
                . "from sxgeo_regions where country= '$id' order by name_ru asc  ")->queryAll();

            return ArrayHelper::map($regions, 'id', 'name_ru');
        } else {
            return false;
        }
    }

    static function getIdByName($name) {
        $city = Yii::$app->db->
        createCommand("select id, name_ru "
            . "from sxgeo_cities where name_ru = '" . trim($name) . "' limit 1 ")->queryAll();

        return $city[0]['id'];
    }

    static function Cities($id = 0) {
        if ($id) {
            $cities = Yii::$app->db->
            createCommand("select id, name_ru "
                . "from sxgeo_cities where region_id= '$id' order by name_ru asc ")->queryAll();
            return ArrayHelper::map($cities, 'id', 'name_ru');
        } else {
            return false;
        }
    }

    static function CitiesSuggest($term) {
        if ($term) {
            $cities = Yii::$app->db->
            createCommand("select id, name_ru as label, name_ru as value "
                . "from sxgeo_cities where name_ru like '%$term%' order by name_ru asc limit 10")->queryAll();
            return $cities;
        } else {
            return false;
        }
    }

}
