<?php

namespace app\models;

use Yii;

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
            [['last_name', 'first_name', 'phone', 'city'], 'required'],
            [['city', 'uid', 'network', 'company'], 'string'],
            [['birthdate'], 'datetime', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'birthdate'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'first_name' => Yii::t('user', 'First name'),
            'last_name' => Yii::t('user', 'Last name'),
            'city' => Yii::t('user', 'City'),
            'phone' => Yii::t('user', 'Phone'),
            'network' => Yii::t('user', 'Network'),
            'uid' => Yii::t('user', 'uid'),
            'company' => Yii::t('user', 'Company'),
            'birthdate' => Yii::t('user', 'Birth Date'),
        );
    }

    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // проверка на возможность оценивания
    public function isRateble()
    {
        if($this->user_id == Yii::$app->user->id) return false;

        return Messages::find()
            ->select('advert_id')
            ->where([
                'sender_id' => Yii::$app->user->id,
                'receiver_id' => $this->user_id,
            ])->joinWith('advert')
            ->andWhere(['<>','adverts.user_id', Yii::$app->user->id])
            ->groupBy(['advert_id'])->all();
    }
}
