<?php
namespace app\widgets;

use yii\base\Widget;

class BulletinCategoryWidget extends Widget
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
        return $this->render('bulletinCategoryWidget', array('model' => $this->model, 'form' => $this->form, 'categories' => $this->categoriesListData()));
    }

    public function categoriesListData() {
        $categoriesTree = Category::roots();
        $categories = array();
        foreach ($categoriesTree as $category) {
            //$categories[$category->name] = ArrayHelper::map($category->children()->findAll(), 'id', 'name');
            $categories[$category->id] = $category->name;
        }
        return $categories;
    }

}

