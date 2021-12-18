<?php
namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;
    const STATUS_ADMIN = 10;
    const STATUS_MODER = 3;

    /**
     * The followings are the available columns in table 'users':
     * @var integer $id
     * @var string $username
     * @var string $password
     * @var string $email
     * @var integer $status
     * @var timestamp $created_at
     * @var timestamp $lastvisit_at
     */


    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->where(['id' => $id])
            ->andWhere(['>', 'status', self::STATUS_NOACTIVE])
            ->one();
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findUserByPasswordToken($token)
    {
        return static::findOne(['password_reset_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        if (strpos($username, '@')) {
            return static::find()
                ->where(['email' => $username])
                ->andWhere(['>', 'status', self::STATUS_NOACTIVE])
                ->one();
        }
        return static::find()
            ->where(['username' => $username])
            ->andWhere(['>', 'status', self::STATUS_NOACTIVE])
            ->one();
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString();
    }


    public function beforeSave($insert)
    {
        if ($insert) {
            $this->generateAuthKey();
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_NOACTIVE, self::STATUS_BANNED]],
            ['lastvisit_at', 'default', 'value' => null],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', "Id"),
            'username' => Yii::t('user', "username"),
            'password' => Yii::t('user', "password"),
            'email' => Yii::t('user', "E-mail"),
            'created_at' => Yii::t('user', "Registration date"),
            'lastvisit_at' => Yii::t('user', "Last visit"),
            'status' => Yii::t('user', "Status"),
        );
    }

    public function scopes() {
        return array(
            'active' => array(
                'condition' => 'status=' . self::STATUS_ACTIVE,
            ),
            'notactive' => array(
                'condition' => 'status=' . self::STATUS_NOACTIVE,
            ),
            'banned' => array(
                'condition' => 'status=' . self::STATUS_BANNED,
            ),
            'superuser' => array(
                'condition' => 'status=' . self::STATUS_ADMIN,
            ),
        );
    }

    public static function itemAlias($type, $code = NULL) {
        $_items = array(
            'UserStatus' => array(
                self::STATUS_NOACTIVE => Yii::t('user', 'Not active'),
                self::STATUS_ACTIVE => Yii::t('user', 'Active'),
                self::STATUS_BANNED => Yii::t('user', 'Banned'),
            ),
            'AdminStatus' => array(
                '0' => Yii::t('user', 'No'),
                '1' => Yii::t('user', 'Yes'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return ActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search( $params ) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere('id', $this->id);
        $query->andFilterWhere('username', $this->username, true);
        $query->andFilterWhere('password', $this->password);
        $query->andFilterWhere('email', $this->email, true);
        $query->andFilterWhere('created_at', $this->created_at);
        $query->andFilterWhere('lastvisit_at', $this->lastvisit_at);
        $query->andFilterWhere('status', $this->status);

        return $dataProvider;
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    public static function getAdmins()
    {
        return self::find()->select('username')
            ->where(['status' => self::STATUS_ADMIN])->asArray()->all();
    }

    public function getAdverts(){
        return $this->hasMany(Adverts::class, ['user_id' => 'id']);
    }

    public function getAvatar($size = 64)
    {
        return \cebe\gravatar\Gravatar::widget([
            'email' => $this->email,
            'defaultImage' => 'identicon',
            'options' => [
                'alt' => $this->username,
                'class' => 'avatar',
            ],
            'size' => $size
        ]);
    }

    public function advertLink()
    {
        $count = $this->getAdverts()->count();
        $title = $this->profile->getName().'(Объявлений '.$count.')';
        return \yii\bootstrap4\Html::a($title, ['user/view', 'id' => $this->id]);
    }

}
