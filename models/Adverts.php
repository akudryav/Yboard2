<?php
namespace app\models;

use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use Yii;
use yii\data\ActiveDataProvider;

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
            [['user_id', 'category_id', 'gallery_id', 'views', 'location'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['price', 'type'], 'double'],
            [['type'], 'safe'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif', 'maxFiles' => 5],
            [['id', 'name', 'user_id', 'category_id', 'type', 'views', 'text', 'price', 'moderated'], 'safe', 'on' => 'search'],
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

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
        );
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUserName()
    {
        return ($this->user) ? $this->user->username : 'Автор';
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
            'gallery_id' => Yii::t('app', 'Gallery'),
            'youtube_id' => Yii::t('app', 'Youtube'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'fields' => Yii::t('adv', 'Fields'),
            'price' => Yii::t('adv', 'Price'),
            'location' => Yii::t('app', 'Location'),
            'moderated' => Yii::t('adv', 'Мoderated'),
        );
    }

    public function beforeSave($insert)
    {
        $post = Yii::$app->request->post();
        if (isset($post['Adpackage']['Page'])) {
            $this->fields = serialize($_POST['Adpackage']['Page']);
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if ($this->fields) {
            $this->fields = unserialize($this->fields);
        }
        parent::afterFind();
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
     * Загрузка файлов
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $filename = 'images/store/' . uniqid() . '.' . $file->extension;
                $file->saveAs($filename);
                $this->attachImage($filename);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return ActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($strict = true)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = (new Query);

        $criteria->from('adverts');
        $criteria->select('adverts.*');


        $criteria->where(['id' => $this->id]);
        $criteria->where(['user_id' => $this->user_id]);

        //$criteria->compare('category_id', $this->category_id);
        if (is_numeric($this->category_id)) {
            $criteria->where('adverts.category_id = "' . $this->category_id . '" '
                . ' or (category.lft > "' . Yii::$app->params['categories'][$this->category_id]['lft'] . '"'
                . ' and category.rgt< "' . Yii::$app->params['categories'][$this->category_id]['rgt'] . '"'
                . ' and category.root = "' . Yii::$app->params['categories'][$this->category_id]['root'] . '")');
        }

        if ($this->fields) {
            $criteria->where(" adverts.fields regexp '" . $this->fields . "' ");
        }

        if (is_numeric($this->price_min) and $this->price_max > 0) {
            $criteria->where("price >= " . $this->price_min . " and price <= " . $this->price_max);
        }


        $criteria->join('inner join', 'category', 'category.id=adverts.category_id');

        $criteria->where(['type' => $this->type]);
        $criteria->where(['location' => $this->location]);
        $criteria->where(['views' => $this->views]);
        $criteria->where(['moderated' => $this->moderated]);
        $criteria->orderBy('adverts.id');
        $criteria->limit(Yii::$app->params['adv_on_page']);

        if ($strict) {
            if ($this->name && $this->text)
                $criteria->andWhere(['or',
                    ['like', 'adverts.name', $this->name],
                    ['like', 'text', $this->text]
                ]);
        } else {
            $search_str = explode(" ", $this->text);
            foreach ($search_str as $v) {
                if (mb_strlen($v) > 2) {
                    $criteria->andWhere(['or',
                        ['adverts.name' => $v],
                        ['text' => $v]
                    ]);
                }
            }
        }

        return new ActiveDataProvider([
            'query' => $criteria,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

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
     * Конвертер валют для выода цены
     */
    public function price_converter()
    {
        $vars = [];
        foreach (Yii::$app->params['currency'] as $cn => $cur) {
            $vars[] = round($this->price / Yii::$app->params['exchange'][$this->currency]
                    * Yii::$app->params['exchange'][$cn], 2) . ' ' . $cur;
        }
        return implode(' | ', $vars);
    }
}
