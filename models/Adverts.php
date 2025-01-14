<?php
namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\bootstrap4\Html;

/**
 * This is the model class for table "adverts".
 *
 * The followings are the available columns in table 'bulletin':
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property integer $category_id
 * @property boolean $type
 * @property integer $views
 * @property string $text
 */
class Adverts extends \yii\db\ActiveRecord
{
    public $imageFiles;
    const TYPE_DEMAND = 0;
    const TYPE_OFFER = 1;
    const STATUS_MODERATED = 0;
    const STATUS_PUBLISHED = 1;

    public $price_min;
    public $price_max;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'adverts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            [['name', 'user_id', 'category_id', 'text'], 'required'],
            [['user_id', 'category_id', 'views'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['price', 'type'], 'double'],
            [['type'], 'safe'],
            ['address', 'string', 'min' => 3, 'tooShort' => Yii::t('adv', 'Find address on the map')],
            ['location', 'string', 'min' => 10, 'tooShort' => Yii::t('adv', 'Find address on the map')],
            [['moderated'], 'default', 'value' => self::STATUS_PUBLISHED],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, gif', 'maxFiles' => 5],
            [['price_min', 'price_max'], 'safe'],
        );
    }

    public static function statusList()
    {
        return [
            self::STATUS_MODERATED => 'На модерации',
            self::STATUS_PUBLISHED => 'Опубликовано',
        ];
    }

    public function statusName()
    {
        return isset(self::statusList()[$this->moderated]) ? self::statusList()[$this->moderated] : 'unknown';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getParams()
    {
        return $this->hasMany(Params::class, ['advert_id' => 'id'])->indexBy('code');
    }

    public function getFavorite()
    {
        return $this->hasOne(Favorites::class, ['obj_id' => 'id'])
            ->where(['user_id' => Yii::$app->user->id, 'obj_type' => 0]);
    }

    public function getFavoriteCount()
    {
        return $this->hasMany(Favorites::class, ['obj_id' => 'id'])
            ->where(['obj_type' => 0])->count();
    }

    public function getCity()
    {
        $parts = explode(', ', $this->address);
        return isset($parts[1]) ? $parts[1] : '';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'user_id' => Yii::t('app', 'User'),
            'category_id' => Yii::t('app', 'Category'),
            'type' => Yii::t('app', 'Type'),
            'views' => Yii::t('app', 'Views'),
            'text' => Yii::t('app', 'Text'),
            'youtube_id' => Yii::t('app', 'Youtube'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'fields' => Yii::t('adv', 'Fields'),
            'price' => Yii::t('adv', 'Price'),
            'location' => Yii::t('adv', 'Location'),
            'address' => Yii::t('adv', 'Address'),
            'moderated' => Yii::t('adv', 'Мoderated'),
            'imageFiles' => Yii::t('adv', 'imageFiles'),
        );
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'type' => array(
                self::TYPE_DEMAND => Yii::t('app', 'Demand'),
                self::TYPE_OFFER => Yii::t('app', 'Offer'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    /**
     * Сохранение параметров
     * @return bool
     */
    public function addParams($data)
    {
        if(empty($data)) return true;
        Params::deleteAll(['advert_id' => $this->id]);
        foreach ($data as $k => $v) {
            $param = new Params();
            $param->code = $k;
            $param->value = $v['value'];
            $this->link('params', $param);
        }
    }

    /**
     * Загрузка файлов
     * @return bool
     */
    public function upload()
    {
        $res = true;
        foreach ($this->imageFiles as $file) {
            $filename = 'images/store/' . uniqid() . '.' . $file->extension;
            $file->saveAs($filename);
            $res = $res && $this->attachImage($filename);
        }
        return $res;
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /*
     * Формирование массива параметров для отображения в карточке
     */
    public function paramsArray()
    {
        $params = $this->params;
        if (!$params) return [];
        $cat_params = Category::fieldData($this->category_id);
        $result = [];
        foreach ($cat_params as $par) {
            $code = $par['code'];
            if (isset($params[$code])) {
                $result[$par['name']] = $params[$code]['value'];
            }
        }
        return $result;
    }

    /*
     * Формирование ссылок на категорию
     */
    public function getCategoryLink()
    {
        $cat = Category::getTree()[$this->category_id];
        return Html::a($cat['name'], ['adverts/category', 'id' =>$this->category_id]);
    }
}
