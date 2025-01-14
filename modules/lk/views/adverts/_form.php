<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$coord = $model->location ? explode(':', $model->location) : [55.7372, 37.6066];
$cat_url = \yii\helpers\Url::to(['category/cat-list']);

$map = new \mirocow\yandexmaps\Map('yandex_map', [
    'center' => $coord,
    'zoom' => 10,
    // Enable zoom with mouse scroll
    'behaviors' => ['default', 'scrollZoom'],
    'type' => "yandex#map",
    'controls' => [],
],
    [
        // Permit zoom only fro 9 to 11
        'minZoom' => 1,
        'maxZoom' => 11,
        'controls' => [
            // v 2.1
            'new ymaps.control.ZoomControl({options: {size: "small"}})',
            //'new ymaps.control.TrafficControl({options: {size: "small"}})',
            //'new ymaps.control.GeolocationControl({options: {size: "small"}})',
            'search' => 'new ymaps.control.SearchControl({options: {size: "large"}})',
            //'new ymaps.control.FullscreenControl({options: {size: "small"}})',
            //'new ymaps.control.RouteEditor({options: {size: "small"}})',
        ],
        'behaviors' => [
            'scrollZoom' => 'disable',
        ],
        'objects' => [
            <<<JS
search.events.add("resultselect", function (e){
    var selected = e.get('index');
    search.getResult(selected).then(function(res) {
        var coordinates = res.geometry.getCoordinates();
        $('#adverts-address').val(res.getAddressLine());
        $('#adverts-location').val(coordinates[0]+':'+coordinates[1]);
    });
});

JS
        ],
    ]
);

?>

<div class="form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'bulletin-form',
        'options' => ['enctype' => 'multipart/form-data'],
        'enableAjaxValidation' => false,
    ]);
    ?>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->field($model, 'name'); ?>
    <?php echo $form->field($model, 'category_id')->dropDownList($categories); ?>
    <div id="params" class="well">
        <?php echo $this->render('/category/_params', [
            'params' => $model->isNewRecord ? [] : $model->params,
            'category_id' => $model->isNewRecord ? array_key_first($categories) : $model->category_id,
            'form' => $form,
        ]) ?>
    </div>
    <?= $form->field($model, 'text')->textarea(['rows' => '6']) ?>
    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?php
    foreach ($model->getImages() as $img) {
        echo Html::img($img->getUrl('x100'));
    }
    ?>
    <?= $form->field($model, 'price'); ?>
    <?= $form->field($model, 'location')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'address')->hiddenInput()->label(false) ?>
    <div class="form-group">
        <label class="form-label">
            <?php echo Yii::t('adv', 'Location') .
                '(' . Yii::t('adv', 'Find address on the map') . ')'; ?>
        </label>
        <?= \mirocow\yandexmaps\Canvas::widget([
            'htmlOptions' => [
                'style' => 'height: 400px;',
            ],
            'map' => $map,
        ]);

        ?>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->