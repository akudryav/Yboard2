<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use \app\models\Params;

$params = Yii::$app->request->post('Params');
$params_list = [];
if (!empty($params)) {
    foreach ($params as $key => $val) {
        $par_model = new Params();
        $par_model->code = $key;
        $par_model->value = $val['value'];
        $params_list[$key] = $par_model;
    }
}

?>
<div class="d-xl-block col-xl-2 bd-toc">
    <b>Фильтр</b>
    <?php
    $form = ActiveForm::begin();
    echo $this->render('@app/modules/lk/views/category/_params', [
        'params' => $params_list,
        'category_id' => $category->id,
        'form' => $form,
    ]);
    echo Html::submitButton(Yii::t('app', 'Фильтровать'), ['class' => 'btn btn-primary']);
    ActiveForm::end();
    ?>
</div>