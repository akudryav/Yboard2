<?php
namespace app\models;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use zxbodya\yii2\galleryManager\GalleryBehavior;
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

    const TYPE_DEMAND = 0;
    const TYPE_OFFER = 1;

    public $price_min;
    public $price_max;

    /**
     * @return string the associated database table name
     */
    public static function tableName() {
        return 'adverts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            [[ 'name', 'user_id', 'category_id', 'text'], 'required'],
            [['user_id', 'category_id', 'gallery_id', 'views', 'location', 'currency'], 'integer' ],
            [['name'], 'string', 'max' => 255],
            [['price', 'type'],  'double'],
            [['type'], 'safe'],
            [['id', 'name', 'user_id', 'category_id', 'type', 'views', 'text', 'price', 'currency', 'moderated'], 'safe', 'on' => 'search'],
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
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
        return $this->hasOne(Category::class, ['category_id' => 'id']);
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
            'fields' => Yii::t('app', 'Fields'),
            'price' => Yii::t('app', 'Price'),
            'location' => Yii::t('app', 'Location'),
            'moderated' => Yii::t('app', 'Мoderated'),
        );
    }

    public static function itemAlias($type, $code = NULL) {
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

        return new ActiveDataProvider(array(
            'query' => $criteria,
            'pagination' => [
                'pageSize' => 2,
            ],
        ));

    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            'galleryBehavior' => [
                'class' => GalleryBehavior::class,
                'type' => 'product',
                'tableName' => 'gallery_images',
                'extension' => 'jpg',
                'directory' => Yii::getAlias('@webroot') . '/images/product/gallery',
                'url' => Yii::getAlias('@web') . '/images/product/gallery',
                'versions' => [
                    'small' => function ($img) {
                        /** @var ImageInterface $img */
                        return $img
                            ->copy()
                            ->thumbnail(new Box(200, 200));
                    },
                    'medium' => function ($img) {
                        /** @var ImageInterface $img */
                        $dstSize = $img->getSize();
                        $maxWidth = 800;
                        if ($dstSize->getWidth() > $maxWidth) {
                            $dstSize = $dstSize->widen($maxWidth);
                        }
                        return $img
                            ->copy()
                            ->resize($dstSize);
                    },
                ]
            ]
        ];
    }

    /**
     * return first GalleryPhoto
     * @return GalleryPhoto
     */
    public function getPhoto()
    {

        $images = $this->getBehavior('galleryBehavior')->getImages();

        if (!empty($images)) {

            return $images[0];
        }
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
