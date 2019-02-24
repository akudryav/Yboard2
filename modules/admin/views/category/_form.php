<!--
 /**
  * Form for JsTreeBehavior model.
  *
  * Date: 1/29/13
  * Time: 12:00 PM
  *
  * @author: Spiros Kabasakalis <kabasakalis@gmail.com>
  * @link http://iws.kabasakalis.gr/
  * @link http://www.reverbnation.com/spiroskabasakalis
  * @copyright Copyright &copy; Spiros Kabasakalis 2013
  * @license http://opensource.org/licenses/MIT  The MIT License (MIT)
  * @version 1.0.0
  */
--><?

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<?php if ($model->isNewRecord) : ?>
    <h3><?php echo Yii::t('global', 'Create') ?> <?php echo Yii::t('global', $modelClassName) ?></h3>
<?php elseif (!$model->isNewRecord): ?>
    <h3><?php echo Yii::t('global', 'Update') ?> <?php echo Yii::t('global', $modelClassName) ?></h3>
<?php endif; ?>

<p> <h2><?php //echo $model->name;  ?></h2></p>

<?php
$val_error_msg = Yii::t('global', "Error.$modelClassName  was not saved.");
$val_success_message = ($model->isNewRecord) ?
        Yii::t('global', "$modelClassName has been created successfully.") :
        Yii::t('global', "$modelClassName  has been updated successfully.");
?>

<div id="success-note" class="alert alert-success"
     style="display:none;">
         <?php echo $val_success_message; ?>
</div>

<div id="error-note" class="alert alert-error"
     style="display:none;">
         <?php echo $val_error_msg; ?>
</div>


<script>
    var new_field_id = 1;

    function addFiled() {
        $('#fields-list').append('<div class="controls"><input type="text"  id="Category_fields_' + new_field_id + '_name" name="Category[fields][fn_' + new_field_id + '][name]" maxlength="128" size="60" value="">			<select id="Category_fields_price_&quot;type&quot;" name="Category[fields][fn_' + new_field_id + '][type]"><option value="0">text</option><option value="1">checkbox</option><option value="2">select</option></select><input type="text" id="Category_fields_' + new_field_id + '_atr" name="Category[fields][fn_' + new_field_id + '][atr]" maxlength="128" size="60" value=""><a href="javascript:void(0);" onclick="delField(this);"><i class="fa fa-times"></i></a></div>');
        new_field_id++;
    }

    function delField(t) {
        $(t).parent().remove();
    }
</script>	

<div id="ajax-form" class='form'>
    <?php
    $formId = "$modelClassName-form";

    $actionUrl = ($model->isNewRecord) ?
            ( ( (!empty($_POST['create_root']) ? $_POST['create_root'] : '') != 'true') ? CController::createUrl($this->id . '/createnode') : CController::createUrl($this->id . '/createRoot')) :
            CController::createUrl($this->id . '/updatenode');

    $form = ActiveForm::begin( array(
        'id' => $formId,
        //  'options' => array('enctype' => 'multipart/form-data'),
        // 'enableAjaxValidation'=>true,
        'enableClientValidation' => true,
        'focus' => array($model, 'name'),
        'errorMessageCssClass' => 'alert alert-error',
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnType' => false,
            'inputContainer' => '.control-group',
            'errorCssClass' => 'error',
            'successCssClass' => 'success',
        ),
    ));
    ?>

    <?php
    echo $form->errorSummary($model, '<div style="font-weight:bold">Please correct these errors:</div>', NULL, array('class' => 'alert alert-error')
    );
    ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <fieldset>


        <!--
        Modify the input fields according to your model.
        -->
        <div class="control-group">
            <?php echo $form->field($model, 'name', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'name', array('value' => !empty($_POST['name']) ? $_POST['name'] : $model->name, 'class' => 'span4', 'size' => 60, 'maxlength' => 128)); ?>
                <p class="help-block"><?php echo $form->field($model, 'name'); ?></p>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->field($model, 'icon', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'icon', array('value' => !empty($_POST['icon']) ? $_POST['icon'] : $model->icon, 'class' => 'span4', 'size' => 60, 'maxlength' => 128)); ?>
                <p class="help-block"><?php echo $form->field($model, 'icon'); ?></p>
            </div>
        </div>

        <div class="control-group">

            <div class="controls">
                <?php echo $form->field($model, 'meta_title', array('class' => 'control-label')); ?>
                <?php
                echo $form->textField($model, 'meta_title', array(
                    'value' => !empty($_POST['meta_title']) ? $_POST['meta_title'] : $model->meta_title,
                    'class' => 'span4', 'size' => 100, 'maxlength' => 200));
                ?>
                <p class="help-block"><?php echo $form->field($model, 'meta_title'); ?></p>
            </div>
            <div class="controls">
                <?php echo $form->field($model, 'meta_descr', array('class' => 'control-label')); ?>
                <?php
                echo $form->textArea($model, 'meta_descr', array(
                    'value' => !empty($_POST['meta_descr']) ? $_POST['meta_descr'] : $model->meta_descr,
                    'class' => 'span4', 'cols' => 100, 'maxlength' => 200));
                ?>
                <p class="help-block"><?php echo $form->field($model, 'meta_descr'); ?></p>
            </div>
            <div class="controls">
<?php echo $form->field($model, 'meta_key', array('class' => 'control-label')); ?>
<?php
echo $form->textField($model, 'meta_key', array(
    'value' => !empty($_POST['meta_title']) ? $_POST['meta_key'] : $model->meta_key,
    'class' => 'span4', 'size' => 100, 'maxlength' => 200));
?>
                <p class="help-block"><?php echo $form->field($model, 'meta_key'); ?></p>
            </div>
            <div class="controls">
<?php echo $form->field($model, 'description', array('class' => 'control-label')); ?>
<?php
echo $form->textArea($model, 'description', array(
    'value' => !empty($_POST['description']) ? $_POST['description'] : $model->description,
    'class' => 'span4', 'cols' => 100, 'maxlength' => 200));
?>
                <p class="help-block"><?php echo $form->field($model, 'description'); ?></p>
            </div>
        </div>


        <input type="hidden" name="YII_CSRF_TOKEN"
               value="<?php echo Yii::$app->request->csrfToken; ?>"/>
        <input type="hidden" name= "parent_id" value="<?php
            echo!empty($_POST['parent_id']) ? $_POST['parent_id'] : '';
            ?>"  />


        <div class="control-group" id="fields-list">



                <?
                if (sizeof($model->fields) > 0) {
                    echo $form->field($model, 'fields', array('class' => 'control-label'));
                    echo "Название, тип и артибуты. Для select "
                    . "атрибут это значения через запятую, <br/> для checkbox - "
                    . "если есть надпись значит checkbox по умолчанию выделен";
                    foreach ($model->fields as $fn => $fl) {
                        ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'fields[' . $fn . '][name]', array(
                            'value' => !empty($_POST['fields'][$fn]['name']) ? $_POST['fields'][$fn]['name'] : $fl->name,
                            'size' => 60, 'maxlength' => 128));
                        $selected = array();
                        $selected[$fl->type] = Array('selected' => 'selected');

                        echo $form->dropDownList($model, 'fields[' . $fn . '][type]', $this->settings['fileds_type'], array('options' => $selected));

                        echo $form->textField($model, 'fields[' . $fn . '][atr]', array(
                            'value' => !empty($_POST['fields'][$fn]['atr']) ? $_POST['fields'][$fn]['atr'] : $fl->atr,
                            'size' => 60, 'maxlength' => 128));

                        echo "<a href='javascript:void(0);' onclick='delField(this);'"
                        . "><i class='fa fa-times'></i></a>";
                        ?>


                        <p class="help-block"><?php echo $form->field($model, 'fields'); ?></p>
                    </div>
    <? }
}
?>
        </div>	

        <a href='javascript:addFiled()'><i class='fa fa-plus-circle'></i>Добавить дополнительное поле</a>

            <?php if (!$model->isNewRecord): ?>
            <input type="hidden" name="update_id"
                   value=" <?php echo $model->id; ?>"/>
<?php endif; ?>
        <div class="control-group">
    <?php
    echo Html::submitButton($model->isNewRecord ? Yii::t('global', 'Submit') : Yii::t('global', 'Save'), array('class' => 'btn btn-large'));
    ?>
        </div>
    </fieldset>
<?php ActiveForm::end(); ?>
</div>
<!-- form -->


