<?php
namespace app\models;
use yii\behaviors\TimestampBehavior;

/**
 * Модель оценок
 */
class Reviews extends \yii\db\ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            [['advert_id', 'author_id', 'profile_id', 'rating', 'reply_to'], 'integer'],
            [['message'], 'string'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function getAdvert()
    {
        return $this->hasOne(Adverts::class, ['id' => 'advert_id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'advert_id' => 'Объявление',
            'author_id' => 'Автор',
            'profile_id' => 'Профиль',
            'rating' => 'Оценка',
            'message' => 'Комментарий',
        );
    }


}
