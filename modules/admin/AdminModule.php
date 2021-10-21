<?php

namespace app\modules\admin;


class AdminModule extends \yii\base\Module
{

    public function init()
    {
        parent::init();

        $this->params['foo'] = 'bar';
        // ... остальной инициализирующий код ...
    }

}
