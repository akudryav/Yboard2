<?php
namespace app\widgets;

use yii\base\Widget;

class UloginWidget extends Widget
{

    //параметры по-умолчанию
    private $params = array(
        'display' => 'panel',
        'fields' => 'first_name,last_name,email',
        'optional' => '',
        'providers' => 'vkontakte,odnoklassniki,mailru,facebook',
        'hidden' => 'twitter,google,yandex,livejournal,openid,lastfm,linkedin,liveid,soundcloud,steam',
        'redirect' => '',
        'logout_url' => '/ulogin/logout'
    );

    public function run() {
        //подключаем JS скрипт
        Yii::$app->clientScript->registerScriptFile('http://ulogin.ru/js/ulogin.js', CClientScript::POS_HEAD);
        return $this->render('uloginWidget', $this->params);
    }

    public function setParams($params) {
        $this->params = array_merge($this->params, $params);
    }

}
