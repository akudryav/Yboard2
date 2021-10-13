<?php
namespace app\widgets;

use yii\base\Widget;

class BulletinTypeWidget extends Widget
{

    /**
     * @var CActiveForm form
     */
    public $form;

    /**
     * @var Bulletin model
     */
    public $model;

    public function run() {
        return $this->render('bulletinTypeWidget', array('model' => $this->model, 'form' => $this->form));
    }

}

