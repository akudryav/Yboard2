<?php

/* @var $categories array */

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

$map = new \mirocow\yandexmaps\Map('yandex_map', [
    'center' => [55.7372, 37.6066],
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
            'search' => 'new ymaps.control.SearchControl({options: {size: "small"}})',
            //'new ymaps.control.FullscreenControl({options: {size: "small"}})',
            //'new ymaps.control.RouteEditor({options: {size: "small"}})',
        ],
        'behaviors' => [
            'scrollZoom' => 'disable',
        ],
        'objects' => [
            <<<JS
search.events.add("resultselect", function (result){

    // Remove old coordinates
    \$Maps['yandex_map'].geoObjects.each(function(obj){
        \$Maps['yandex_map'].geoObjects.remove(obj);
    });  

    // Add selected coordinates
    var index = result.get('index');
    var searchControl = \$Maps['yandex_map'].controls.get(1);
    searchControl.getResult(index).then(function(res) {
        var coordinates = res.geometry.getCoordinates();
        $('#coordinates').html('');
        $('#coordinates').append('<input type="hidden" name="User[coordinates][]" value="'+coordinates[0]+'">');
        $('#coordinates').append('<input type="hidden" name="User[coordinates][]" value="'+coordinates[1]+'">');
    });
    
});
JS
        ],
    ]
);

?>

<div class="form well">

    <?php
    $form = ActiveForm::begin([
        'id' => 'bulletin-form',
        'options' => ['enctype' => 'multipart/form-data'],
        'enableAjaxValidation' => false,
    ]);
    ?>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->field($model, 'name'); ?>
    <?php echo $form->field($model, 'category_id')->widget(Select2::class, [
        'data' => $categories,
        'options' => ['placeholder' => Yii::t('app', 'Choose category')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?= $form->field($model, 'text')->textarea(['rows' => '6']) ?>
    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?php echo $form->field($model, 'price'); ?>
    <?= \mirocow\yandexmaps\Canvas::widget([
        'htmlOptions' => [
            'style' => 'height: 400px;',
        ],
        'map' => $map,
    ]);

    ?>

    <div id="coordinates"></div>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->