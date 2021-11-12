<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property integer $id
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property string $message
 * @property string $created_at
 * @property boolean $read
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['advert_id', 'receiver_id', 'message'], 'required'],
            [['advert_id', 'sender_id', 'receiver_id'], 'integer'],
            ['read', 'default', 'value' => 0],
            ['sender_id', 'default', 'value' => Yii::$app->user->id],
            [['advert', 'author'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'advert' => Yii::t('message', 'Advert'),
            'author' => Yii::t('message', 'Author'),
            'sender_id' => Yii::t('message', 'Sender'),
            'receiver_id' => Yii::t('message', 'Receiver'),
            'message' => Yii::t('message', 'Message'),
            'created_at' => Yii::t('message', 'Send Date'),
            'read' => Yii::t('message', 'Read'),
        );
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'sender_id']);
    }

    public function getAdvert()
    {
        return $this->hasOne(Adverts::class, ['id' => 'advert_id']);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return ActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($params)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $query = Messages::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'creation_date', $this->creation_date]);

        return $dataProvider;
    }

}
