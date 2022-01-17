<?php

namespace app\controllers;

use app\models\Profile;
use app\models\Reviews;
use Yii;


class ReviewsController extends Controller
{
    /**
     * Голосование за пользователя
     */
    public function actionRating()
    {
        $this->layout = false;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $review = new Reviews();
        if ($request->isPost && $review->load($request->post())) {
            if ($review->validate()) {
                // вносим в список который уже проголосовали
                $session['rating_ids'][] = $review->profile_id;
                return ['success' => $review->save(false), 'profile' => $review->profile];
            } else {
                $msg = '';
                foreach($review->errors as $err) {
                    $msg .= implode(', ', $err);
                }
                return ['success' => false, 'errors' => $msg];
            }

        }

    }

}
