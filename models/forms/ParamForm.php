<?php

namespace app\models\forms;

use Yii;

/**
 * ParamForm class.
 */
class ParamForm extends \yii\base\Model
{
    public $code;
    public $name;
    public $values;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['code', 'name'], 'required'],
            // verifyCode needs to be entered correctly
            ['values', 'safe'],
        ];
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'code' => 'Код параметра',
            'name' => 'Название параметра',
            'values' => 'Список значений параметра (если нужно)',
        );
    }

}
