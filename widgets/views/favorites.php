<?php

use yii\bootstrap4\Html;

if ($is_favor) {
    $title = 'Удалить из избранного';
    $class = 'fa fa-bookmark';
} else {
    $title = 'Добавить в избранное';
    $class = 'fa fa-bookmark-o';
}
$lnk_content = ($type == 'badge') ? '<i class="' . $class . '"></i>' : $title;
$lnk_params = ['data' => [
    'id' => $model->id,
]];

if ($type == 'button') {
    $lnk_params['class'] = 'btn btn-info js_favor';
} else {
    $lnk_params['class'] = 'js_favor';
}
?>

<?php
if (!Yii::$app->user->isGuest) {
    echo Html::a($lnk_content, '#', $lnk_params);
}

?>
