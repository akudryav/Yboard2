<?php
namespace app\modules\Cms;

class CmsModule extends \yii\base\Module
{

    public function init()
    {
        parent::init();

        $this->params['foo'] = 'bar';
        // ... остальной инициализирующий код ...
    }

}
