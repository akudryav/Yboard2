<?php

use kartik\select2\Select2;

?>
 <li class="list-group-item">
    <div class="row">
        <div class="col-md-auto">
            <?php
            echo Select2::widget([
                'model' => $model,
                'attribute' => "[{$index}]values",
                'options' => ['multiple' => true, 'placeholder' => 'Добавить значение'],
                'pluginOptions' => [
                    'tokenSeparators' => [',', ', '],
                    'allowClear' => true,
                    'tags' => true,
                ],
                'data' => [],
            ]);
            ?>
        </div>
        <div class="col-md-auto">
            <a class="text-danger delete-item"><i class="fa fa-times"></i></a>
        </div>
    </div>
</li>
