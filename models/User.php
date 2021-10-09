<?php
namespace app\models;

use yii\web\IdentityInterface;

class User extends Model implements IdentityInterface {

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;
    //TODO: Delete for next version (backward compatibility)
    const STATUS_BANED = -1;

    public $full_name;
    public $skype;
    public $username;
    public $auth_key;

    const USERS_PROCESSING = 10;

    /**
     * The followings are the available columns in table 'users':
     * @var integer $id
     * @var string $username
     * @var string $password
     * @var string $email
     * @var string $activkey
     * @var integer $createtime
     * @var integer $lastvisit
     * @var integer $superuser
     * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
     */

    
    public static function tableName()
    {
        return 'users';
    }

    public function can($permissionName, $params = [], $allowCaching = true)
    {
        die("web user");
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
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

        return static::findOne(['username' => $username]);

    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
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
        return $this->password === $password;
    }
    
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /**
     * @return string the associated database table name
     */


    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.CConsoleApplication

        return array(
            array('username', 'length', 'max' => 20, 'min' => 3,
                'message' => t("Incorrect username (length between 3 and 20 characters).")),
            array('password', 'length', 'max' => 128, 'min' => 4,
                'message' => t("Incorrect password (minimal length 4 symbols).")),
            array('email', 'email'),
            array('username', 'unique', 'message' => t("This user's name already exists.")),
            array('email', 'unique', 'message' => t("This user's email address already exists.")),
            //array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => t("Incorrect symbols (A-z0-9).")),
            array('status', 'in', 'range' => array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BANNED)),
            array('superuser', 'in', 'range' => array(0, 1)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'),
                'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => date('Y-m-d H:i:s'),
                'setOnEmpty' => true, 'on' => 'insert'),
            array('username, email, superuser, status', 'required'),
            array('superuser, status', 'numerical', 'integerOnly' => true),
            array('location, contacts, skype', 'type', 'type' => 'string'),
            array('lastvisit_at, birthday, create_at', 'date', 'format' => array('yyyy-MM-dd', 'yyyy-MM-dd hh:mm:ss')),
            //array('phone', 'match', 'pattern' => '/^[-\+0-9 ]+$/'),
            array(['id', ' username', ' password', ' email', ' activkey', ' create_at', ' birthday', ' location', ' phone', ' skype', ' contacts', ' lastvisit_at', ' superuser', ' status'], 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        /*
          $relations = Yii::$app->getModule('user')->relations;
          if (!isset($relations['profile']))
          $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
          return $relations;
         * 
         */
        return array();
    }

    static function usersPage($page = 0) {
        $criteria = new CDbCriteria();
        $criteria->compare('status', USER::STATUS_ACTIVE);
        $criteria->limit = self::USERS_PROCESSING;
        $criteria->offset = self::USERS_PROCESSING * $users_pagem;

        return self::findAll($criteria);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => t("Id"),
            'username' => t("username"),
            'password' => t("password"),
            'verifyPassword' => t("Retype Password"),
            'email' => t("E-mail"),
            'verifyCode' => t("Verification Code"),
            'activkey' => t("activation key"),
            'createtime' => t("Registration date"),
            'create_at' => t("Registration date"),
            'lastvisit_at' => t("Last visit"),
            'superuser' => t("Superuser"),
            'status' => t("Status"),
            'full_name' => t("Full name"),
            'phone' => t("phone"),
            'birthday' => t("birthday"),
            'contacts' => t("Contacts"),
            'location' => t("Location"),
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
                'condition' => 'superuser=1 or superuser=2',
            ),
            'notsafe' => array(
                'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status',
            ),
        );
    }

    public function defaultScope() {
        return CMap::mergeArray(Yii::$app->getModule('user')->defaultScope, array(
                    'alias' => 'user',
        ));
    }

    public static function itemAlias($type, $code = NULL) {
        $_items = array(
            'UserStatus' => array(
                self::STATUS_NOACTIVE => t('Not active'),
                self::STATUS_ACTIVE => t('Active'),
                self::STATUS_BANNED => t('Banned'),
            ),
            'AdminStatus' => array(
                '0' => t('No'),
                '1' => t('Yes'),
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
        $query->andFilterWhere('superuser', $this->superuser);
        $query->andFilterWhere('status', $this->status);

        return $dataProvider;
    }

    public static function getAdmins() {
        $admins = self::find()->where(['superuser'=>1])->all();
        $return_name = array();
        foreach ($admins as $admin)
            array_push($return_name, $admin->username);

        return $return_name;
    }

    public static function getUserByName($username) {
        return self::findByAttributes(array('username' => $username));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at = date('Y-m-d H:i:s', $value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at = date('Y-m-d H:i:s', $value);
    }

    public function getAdverts(){
        return $this->hasMany( Adverts::className(), ['customer_id' => 'id']);
    }

}
