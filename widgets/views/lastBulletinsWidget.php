<?php

/* @var $bulletins array */
/* @var $model Bulletin */
?>

<table class="lastBulletins">
    <thead>
        <tr>
            <th colspan="5">
                Новыe объявления:
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bulletins as $model): ?>
            <tr>
                <td><?php echo $model->itemAlias('type', $model->type); ?></td>
                <td><?php echo Yii::$app->dateFormatter->formatDateTime($model->created_at); ?></td>
                <td><?php echo Html::a(Html::encode($model->category->name), array('site/category', 'id' => $model->category->id)); ?></td>
                <td>
                    <?php if ($model->getPhoto()): ?>
                        <img src="<?php echo $model->getPhoto()->getPreview(); ?>" width="150" alt="<?php echo Html::encode($model->name) ?>" />
                    <?php endif; ?>
                </td>
                <td><?php echo Html::a(Html::encode($model->name), array('site/bulletin', 'id' => $model->id)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>