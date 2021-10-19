<?php

namespace app\models;

/**
 * This is the model class for table "reviews".
 *
 * The followings are the available columns in table 'reviews':
 * @property integer $id
 * @property integer $profile_id
 * @property integer $user_id
 * @property integer $type
 * @property string $review
 * @property integer $vote
 */
class Profile extends \yii\db\ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return [
            [['last_name', 'first_name'], 'required'],
            [['country', 'phone', 'uid', 'birthdate', 'network'], 'string'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'country' => 'Страна',
            'phone' => 'Телефон',
            'network' => 'Сервис',
            'uid' => 'Идентификатор сервиса',
            'birthdate' => 'Дата рождения',
        );
    }


}
