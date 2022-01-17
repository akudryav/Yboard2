<?php
namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Модель оценок
 */
class Reviews extends \yii\db\ActiveRecord
{

    public $profile;
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
            [['advert_id','rating'], 'required', 'skipOnEmpty' => false],
            [['advert_id', 'author_id', 'profile_id', 'reply_to'], 'integer'],
            ['advert_id', 'exist', 'targetClass' => 'app\models\Adverts', 'targetAttribute' => 'id'],
            ['profile_id', 'checkIsRateble', 'skipOnEmpty' => false],
            ['profile_id', 'exist', 'targetClass' => 'app\models\User', 'targetAttribute' => 'id'],
            ['author_id', 'default', 'value' => Yii::$app->user->id],
            [['rating'], 'number', 'min' => 0, 'max' => 5],
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

    /** Дополнительные правила проверки атрибутов
     * @param $attribute
     * @param $params
     */
    public function checkIsRateble($attribute, $params)
    {
        $session = Yii::$app->session;
        if (!isset($session['rating_ids'])) {
            $session['rating_ids'] = array();
        }

        $review = self::findOne([
            'advert_id'=>$this->advert_id,
            'author_id'=>Yii::$app->user->id
        ]);

        if($review) {
            $this->addError($attribute, 'Вы уже оценивали этого продавца');
            return false;
        }
        $advert = Adverts::findOne($this->advert_id);
        if(!$advert) {
            return false;
        }
        $this->profile_id = $advert->user_id;
        if (in_array($this->profile_id, $session['rating_ids'])) {
            $this->addError($attribute, 'Вы уже оценивали этого продавца');
            return false;
        }
        $profile = Profile::findOne(['user_id' => $this->profile_id]);
        $chats = $profile->isRateble();
        if (!$chats) {
            $this->addError($attribute, 'Оценка данного пользователя не доступна');
            return false;
        }
        return true;

    }
    // пересчет среднего рейтинга
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $profile = Profile::findOne(['user_id' => $this->profile_id]);
        $rate = ($profile->rating_avg * $profile->rating_count + $this->rating) / ($profile->rating_count + 1);
        $profile->updateAttributes(['rating_avg' => $rate, 'rating_count' => $profile->rating_count + 1]);
        $this->profile = ['rating_avg' => $rate, 'rating_count' => $profile->rating_count];
    }

}
