<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use yii\data\ActiveDataProvider;
use app\models\Adverts;

class Controller extends \yii\web\Controller
{

    /**
     * Lists all models.
     */
    public $breadcrumbs = array();
    private $_behaviorIDs = array();
    public $menu = array();
    // данные для генерации мета данных title, description, keywords
    public $meta = array();
    public $settings = array();
    public $banners = array();
    public $categories = array();
    public $title = "";
    public $fixedAdvers;
    public $adv_count = 0;
    public $searchArt = array('gender' => false,
        'find_gender' => false,
        'location' => false,
        'cat_id' => false,
    );

    public function getBanner($var = false) {
        $debug = "";
        $banner_code = "";
        $cond_banners = array(); // баннеры подходящие по условиям


        if ($var === false) {
            $footer_str = "";
            foreach ($this->banners['__FOOTER__'] as $bn) {
                $footer_str .= $bn;
            }

            return $footer_str;
        }

        if (isset($this->banners[$var]) and sizeof($this->banners[$var]) > 0) {
            if (is_array($this->banners[$var])) {
                // Составление списка баннеров подходящих по условиям 
                foreach ($this->banners[$var] as $b_id => $banner) {
                    if ($banner['enable'] !== "false") {
                        if (is_array($banner['conditions']) and sizeof($banner['conditions']) > 0) {
                            foreach ($banner['conditions'] as $cond) {
                                // Сравнение Get параметров
                                if (isset($cond['parameter'])) {
                                    if ($cond['compare'] === "1") {
                                        if ($_GET[$cond['parameter']] === $cond['value']) {
                                            $cond_banners[] = $b_id;
                                        }
                                    } elseif ($cond['compare'] === "0") {
                                        if ($_GET[$cond['parameter']] !== $cond['value']) {
                                            $cond_banners[] = $b_id;
                                        }
                                    } elseif ($cond['exist'] === "1") {
                                        if (isset($_GET[$cond['parameter']])) {
                                            $cond_banners[] = $b_id;
                                        }
                                    } elseif ($cond['exist'] === "0") {
                                        if (!isset($_GET[$cond['parameter']])) {
                                            $cond_banners[] = $b_id;
                                        }
                                    }
                                }
                                // Сравнение URL 
                                if (isset($cond['url'])) {
                                    if ($cond['compare'] === "1") {
                                        if (Yii::$app->request->requestUri === $cond['url']) {
                                            $cond_banners[] = $b_id;
                                        }
                                    } elseif ($cond['compare'] === "0") {
                                        if (Yii::$app->request->requestUri !== $cond['url']) {
                                            $cond_banners[] = $b_id;
                                        }
                                    }
                                }
                            }
                        } else {
                            $cond_banners[] = $b_id;
                        }
                    }
                }
            } else {
                $banner_code = $this->banners[$var];
            }

            if (sizeof($cond_banners) > 0) {
                // вывод одного из подощедших баннеров
                $b_id = $cond_banners[array_rand($cond_banners, 1)];
                if ($this->banners[$var][$b_id]['title']) {
                    $debug = "\"" . $this->banners[$var][$b_id]['title'] . "\"";
                }
                $banner_code = $this->banners[$var][$b_id]['code'];
                $this->banners['__FOOTER__'][] = $this->banners[$var][$b_id]['code_footer'];
            }
        }

        // var_dump( $this->banners );

        if ($_COOKIE['adv_debug'] === "yes") {
            $debug = "<div style='background:#990000; min-height:20px;' align='center'>" . $var . " - " . $debug . "</div>";
            if (!isset($this->banners[$var]))
                $debug .= "No Ads";
        }

        return "<div class='pblock " . $var . "' >"
                . $debug . $banner_code
                . "</div>";
    }


    public function meta_title() {

        $title = $this->subMetaVars($this->meta['title']);
        return $title;
    }

    public function meta_description() {
        $description = $this->subMetaVars($this->meta['description']);
        return $description;
    }

    public function subMetaVars($str) {
        if (strpos($str, "<") !== false) {
            preg_match_all("~<([-_0-9a-z]+)>~is", $str, $m_v);
            foreach ($m_v[1] as $v) {
                if (isset($this->meta['vars'][$v])) {
                    $str = str_replace("<" . $v . ">", $this->meta['vars'][$v], $str);
                } else {
                    $str = preg_replace("~\[" . $v . "[^\[\]]*\]~is", "", $str);
                    $str = preg_replace("~[^\.]*<" . $v . ">[^\.]*\.~is", "", $str);
                }
            }
            $str = str_replace("]", "", $str);
            $str = str_replace("[", "", $str);
        }

        return $str;
    }


}
