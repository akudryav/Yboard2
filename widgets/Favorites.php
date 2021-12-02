<?php
namespace app\widgets;

use yii\base\Widget;

/**
 *  Виджет добавления в избранное
 */
class Favorites extends Widget
{
    /**
     * @var $type string режим отображения значок badge (по умолчанию) или кнопка button
     */
    public $type = 'badge';
    /*
     * Модель объявления
     */
    public $model;


    public function run()
    {
        return $this->render('favorites', [
            'type' => $this->type, 'model' => $this->model, 'is_favor' => (bool)$this->model->favorite
        ]);
    }

}
