<?php

namespace app\widgets;

use Yii;
use app\models\Messages;
use yii\base\Widget;

class Message extends Widget
{
    public $advert;

    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return 'Для отправки сообщений нужно войти';
        }
        if ($this->advert->user_id == Yii::$app->user->id) {
            return false;
        }
        // Модель для моментального сообщения со страницы просмотра объявления
        $chat = Messages::find()
            ->where(['advert_id' => $this->advert->id, 'sender_id' => Yii::$app->user->id])
            ->orderBy('id DESC')->limit(1)->one();
        if ($chat) {
            $chat_id = $chat->chat_id;
        } else {
            $chat_id = $this->advert->id . '_' . Yii::$app->user->id;
        }

        return $this->render('message', ['chat_id' => $chat_id]);
    }
}