<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use jisoft\sypexgeo\Sypexgeo;

/**
 * Модель геолокации
 */
class Location extends \yii\base\Model
{

    static function geoDetect()
    {
        $session = Yii::$app->session;
        // get by remote IP
        if (empty($session['location'])) {
            $geo = new Sypexgeo();
            $geo->get();
            $session['location'] = $geo->city;
        }

        return $session['location'];
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
