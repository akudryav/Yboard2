<?php

use yii\bootstrap4\Html;

foreach ($categories as $root):
    ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <?php echo isset($root['items']) ? $root['label']
                    : Html::a($root['label'], ['adverts/create', 'cat_id' => $root['id']], ['class' => 'card-link']); ?>
            </h5>
            <?php
            if (isset($root['items'])) {
                foreach ($root['items'] as $item) {
                    echo Html::a($item['label'], ['adverts/create', 'cat_id' => $item['id']], ['class' => 'card-link']);
                }
            }
            ?>
        </div>
    </div>
<?php endforeach ?>