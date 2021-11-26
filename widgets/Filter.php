<?php

namespace app\widgets;

use yii\base\Widget;

class Filter extends Widget
{
    public $cat = null;

    public function run()
    {
        if (!$this->cat->fields) {
            return false;
        }

        return $this->render('filter', ['category' => $this->cat]);
    }
}