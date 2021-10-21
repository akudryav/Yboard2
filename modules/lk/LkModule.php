<?php
namespace app\modules\lk;

class LkModule extends \yii\base\Module
{

    public function init()
    {
        parent::init();

        $this->params['foo'] = 'bar';
        // ... остальной инициализирующий код ...
    }

}
