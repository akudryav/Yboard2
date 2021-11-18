<?php

namespace app\widgets;

use Yii;
use app\models\Messages;
use yii\base\Widget;

class Chat extends Widget
{
    public $chat_id = null;

    public function init() {
        // готовим сообщения чата(ов)
        $query = Messages::find()->where(['or',
            ['sender_id' => Yii::$app->user->id],
            ['receiver_id' => Yii::$app->user->id],
        ])->with('advert');
        if($this->chat_id) {
            $query->andWhere(['chat_id' => $this->chat_id]);
        }
        parent::init();
    }

    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }


        // Модель для моментального сообщения со страницы просмотра объявления
        $model = new Messages();
        $model->advert_id = $this->advert->id;
        $model->receiver_id = $this->advert->user_id;
        $chat = Messages::find()
            ->where(['advert_id' => $this->advert->id, 'sender_id' => Yii::$app->user->id])
            ->orderBy('id DESC')->limit(1)->one();
        if ($chat) {
            $model->chat_id = $chat->chat_id;
        } else {
            $model->chat_id = $this->advert->id . '_' . Yii::$app->user->id;
        }

        return $this->render('message', ['model' => $model]);
    }
}