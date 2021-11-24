<?php

namespace app\models;


class Params extends \yii\db\ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'params';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return [
            [['advert_id', 'code', 'value'], 'required'],
            [['advert_id'], 'integer'],
            [['code', 'value'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Код параметра',
            'value' => 'Значение',
        );
    }

}
