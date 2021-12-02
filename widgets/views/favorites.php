<?php
if ($is_favor) {
    $title = 'Удалить из избранного';
    $class = 'fa fa-bookmark';
} else {
    $title = 'Добавить в избранное';
    $class = 'fa fa-bookmark-o';
}
?>
    <i class="fa fa-eye"></i><?= $model->views ?>
<?php if (!Yii::$app->user->isGuest): ?>
    <a href="javascript:void(0)" title="<?= $title ?>" onclick="setFavoriteAdv(<?= $model->id ?>, this)"
        <?php if ($type == 'button') echo 'class="btn btn-default"'; ?>>
        <?php if ($type == 'badge'): ?><i class="<?= $class ?>"></i><?php else: echo $title; ?><?php endif ?>
    </a>
<?php endif ?>