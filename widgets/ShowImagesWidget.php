<?php
namespace app\widgets;

use yii\base\Widget;

class ShowImagesWidget extends Widget
{

    /**
     * @var Bulletin
     */
    public $bulletin;

    public function run()
    {
        return $this->render('showImagesWidget', array('bulletin' => $this->bulletin));
    }

}

