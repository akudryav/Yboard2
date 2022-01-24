<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;

class UserMenu extends Widget
{
    public function run()
    {
        if (Yii::$app->user->isGuest) {
            $menuItems = [[
                'label' => 'Войти',
                'url' => ['/user/login'],
                'linkOptions'=>[
                    'class'=>'default_btn header__options_auth',
                    'data' => ['open-modal' => 'auth']
                ]
            ]];
        } else {
            $menuItems = [
                ['label' =>  Yii::$app->user->identity->getAvatar(30),
                 'encode' => false,
                 'items' => [
                     [
                         'label' => 'Мои объявления',
                         'url' => ['/lk/adverts'],
                     ],
                     [
                         'label' => 'Мои сообщения',
                         'url' => ['/lk/messages'],
                     ],
                     [
                         'label' => 'Закладки',
                         'url' => ['/lk/adverts/favorites'],
                     ],
                     [
                         'label' => 'Профиль',
                         'url' => ['/lk/profile'],
                     ],
                    [
                        'label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/user/logout'],
                        'linkOptions' => [
                            'data-method' => 'post'
                        ]
                    ]
                ]],
            ];
        }
        return $this->render('usermenu', [
            'menuItems' => $menuItems,
        ]);
    }
}