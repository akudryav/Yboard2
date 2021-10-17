<?php
namespace app\models;

use Yii;
use yii\web\IdentityInterface;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;
    const STATUS_ADMIN = 2;

    public $full_name;
    public $skype;
    public $username;
    public $auth_key;

    /**
     * The followings are the available columns in table 'users':
     * @var integer $id
     * @var string $username
     * @var string $password
     * @var string $email
     * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
     */


    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
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

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        if (strpos($username, '@')) {
            return static::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE]);
        }
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
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


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_NOACTIVE, self::STATUS_BANNED]],
            ['create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'on' => 'insert'],
            ['lastvisit_at', 'default', 'value' => null, 'on' => 'insert'],
            ['username', 'safe', 'on' => 'insert'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', "Id"),
            'username' => Yii::t('app', "username"),
            'password' => Yii::t('app', "password"),
            'verifyPassword' => Yii::t('app', "Retype Password"),
            'email' => Yii::t('app', "E-mail"),
            'verifyCode' => Yii::t('app', "Verification Code"),
            'activkey' => Yii::t('app', "activation key"),
            'create_at' => Yii::t('app', "Registration date"),
            'lastvisit_at' => Yii::t('app', "Last visit"),
            'status' => Yii::t('app', "Status"),
            'full_name' => Yii::t('app', "Full name"),
            'phone' => Yii::t('app', "phone"),
            'birthday' => Yii::t('app', "birthday"),
            'contacts' => Yii::t('app', "Contacts"),
            'location' => Yii::t('app', "Location"),
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
                self::STATUS_NOACTIVE => Yii::t('app', 'Not active'),
                self::STATUS_ACTIVE => Yii::t('app', 'Active'),
                self::STATUS_BANNED => Yii::t('app', 'Banned'),
            ),
            'AdminStatus' => array(
                '0' => Yii::t('app', 'No'),
                '1' => Yii::t('app', 'Yes'),
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
        $query->andFilterWhere('activkey', $this->activkey);
        $query->andFilterWhere('create_at', $this->create_at);
        $query->andFilterWhere('lastvisit_at', $this->lastvisit_at);
        $query->andFilterWhere('status', $this->status);

        return $dataProvider;
    }

    public static function getAdmins() {
        $admins = self::find()->where(['status' => 2])->all();
        $return_name = array();
        foreach ($admins as $admin)
            array_push($return_name, $admin->username);

        return $return_name;
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at = date('Y-m-d H:i:s', $value);
    }

    public function getAdverts(){
        return $this->hasMany(Adverts::class, ['customer_id' => 'id']);
    }

}
