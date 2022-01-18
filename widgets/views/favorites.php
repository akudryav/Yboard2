<?php

use yii\bootstrap4\Html;

if ($is_favor) {
    $title = 'Удалить из избранного';
} else {
    $title = 'Добавить в избранное';
}
$lnk_content = ($type == 'badge') ? '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12.333 5.673L12 5.97l-.333-.298C10.487 4.618 9.229 4 8 4 4.962 4 3 5.962 3 9c0 4.01 3.244 7.656 8.842 10.975a.4.4 0 0 0 .326-.004C17.772 16.615 21 12.996 21 9c0-3.038-1.962-5-5-5-1.229 0-2.488.618-3.667 1.673zM16 3c3.59 0 6 2.41 6 6 0 4.452-3.44 8.308-9.311 11.824-.394.246-.98.246-1.366.006C5.46 17.353 2 13.466 2 9c0-3.59 2.41-6 6-6 1.39 0 2.746.61 4 1.641C13.254 3.61 14.61 3 16 3z"></path></svg>'
    : $title;
$lnk_params = ['data' => [
    'id' => $model->id,
]];

if ($type == 'button') {
    $lnk_params['class'] = 'btn btn-info js_favor';
} else {
    $lnk_params['class'] = 'product-item__favorite js_favor';
}

if (!Yii::$app->user->isGuest) {
    echo Html::a($lnk_content, '#', $lnk_params);
}

?>
