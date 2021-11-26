<?php

use yii\bootstrap4\ActiveForm;

?>
<div class="d-xl-block col-xl-2 bd-toc">
    <b>Фильтр</b>
    <?php
        $form = ActiveForm::begin();
        echo $this->render('@app/modules/lk/views/adverts/_params', [
            'params' => [],
            'category' => $category,
            'form' => $form,
        ]);
        ActiveForm::end();
    ?>
</div>