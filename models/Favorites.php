<?php
namespace app\models;
/**
 * This is the model class for table "favorites".
 *
 * The followings are the available columns in table 'favorites':
 * @property integer $id
 * @property integer $user_id
 * @property integer $obj_id
 * @property integer $obj_type
 */
class Favorites extends \yii\db\ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'favorites';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['user_id', 'obj_id', 'obj_type'], 'integer'],
        ];
    }

    public function getAdvert()
    {
        return $this->hasOne(Adverts::class, ['id' => 'obj_id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'obj_id' => 'Obj',
            'obj_type' => 'Obj Type',
        );
    }



}
