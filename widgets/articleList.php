<?php

namespace app\widgets;

use yii\base\Widget;

/**
 * Выводит панель продвинутого поиска для определенной категории
 *
 * @author Max Uglov <vencendor@mail.ru>
 *
 *
 */
class articleList extends Widget
{

    /**
     * @var CActiveForm form
     */
    public function run()
    {

        $model = new Cms();
        $art_list = $model->getPageList();

        foreach ($art_list as $art) {
            echo "<a href='" . Url::base() . "/" . $art->url . "'>" . $art->name . "</a>";
        }
    }

}
