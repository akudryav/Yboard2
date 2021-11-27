<?php
use yii\helpers\ArrayHelper;

$cat_params = \app\models\Category::fieldData($category->fields);

if($cat_params) {
    foreach($cat_params as $par) {
        $code = $par['code'];
        $par_model = isset($params[$code]) ? $params[$code] : new \app\models\Params();
        if(isset($par['values'])) {
            $values = ArrayHelper::index(explode(',',$par['values']), function ($element) {
                return $element;
            });
            echo $form->field($par_model, "[$code]value")->dropDownList($values)->label($par['name']);
        } else {
            echo $form->field($par_model, "[$code]value")->label($par['name']);
        }

    }
}
