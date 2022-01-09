<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 *  Виджет добавления в избранное
 */
class Favorites extends Widget
{
    /**
     * @var $type string режим отображения значок badge (по умолчанию) или кнопка button
     */
    public $type = 'badge';
    /**
     * Модель объявления
     */
    public $model;
    /**
     * Список уже избранных объявлений для текущего юзера
     */
    private static $favor_list;

    public function init()
    {
        parent::init();

        if (self::$favor_list === null) {
            $array = \app\models\Favorites::find()->where([
                'user_id' => Yii::$app->user->id,
                'obj_type' => 0,
            ])->all();
            self::$favor_list = ArrayHelper::getColumn($array, 'obj_id');
        }
    }

    public function run()
    {
        return $this->render('favorites', [
            'type' => $this->type,
            'model' => $this->model,
            'is_favor' => in_array($this->model->id, self::$favor_list),
        ]);
    }

}
