<?php

namespace app\widgets;

use app\models\Messages;
use yii\base\Widget;

class Message extends Widget
{
    public $advert;
    private $model;

    public function init()
    {
        parent::init();
        // Модель для моментального сообщения со страницы просмотра объявления
        $this->model = new Messages();
        $this->model->advert_id = $this->advert->id;
        $this->model->receiver_id = $this->advert->user_id;
    }

    public function run()
    {
        return $this->render('message', ['model' => $this->model]);
    }
}