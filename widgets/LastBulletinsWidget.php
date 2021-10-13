<?php
namespace app\widgets;

use yii\base\Widget;

class LastBulletinsWidget extends Widget
{

    /**
     * @var int Count of last bulletins
     */
    public $limit = 20;

    public function run()
    {
        return $this->render('lastBulletinsWidget', array('bulletins' => $this->lastBulletins()));
    }

    public function lastBulletins() {
        $dataProvider = new ActiveDataProvider('Bulletin', array(
            'criteria' => array(
                'order' => 'id DESC',
                'limit' => $this->limit,
            ),
        ));
        return $dataProvider->getData();
    }

}
