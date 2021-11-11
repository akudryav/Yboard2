<?php

namespace app\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $name
 * @property string $icon
 */
class Category extends \yii\db\ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public static function tableName() {
        return 'category';
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'level',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['position'], 'default', 'value' => 0],
            [['tree', 'lft', 'rgt', 'depth', 'position'], 'integer'],
            [['name', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('app', 'Category name'),
            'tree' => Yii::t('app', 'Tree'),
            'parentId' => Yii::t('app', 'Parent'),
            'icon' => Yii::t('app', 'Icon'),
            'fields' => Yii::t('app', 'Aditionl fields'),
            'position' => Yii::t('app', 'Position'),
            'description' => Yii::t('app', 'Description'),
        );
    }

    /**
     * Получаем индексированный список всех категорий
     */
    public static function getIndexed()
    {
        $result = self::getDb()->cache(function ($db) {
            return self::find()->indexBy('id')->all();
        });
        return $result;
    }


    /**
     * Get parent's ID
     * @return \yii\db\ActiveQuery
     */
    public function getParentId()
    {
        $parent = $this->parent;
        return $parent ? $parent->id : null;
    }

    /**
     * Get parent's node
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->parents(1)->one();
    }

    /**
     * Get a full tree as a list, except the node and its children
     * @param  integer $node_id node's ID
     * @return array array of node
     */
    public static function getTree($node_id = 0)
    {
        // don't include children and the node
        $children = [];

        if ( ! empty($node_id))
            $children = array_merge(
                self::findOne($node_id)->children()->column(),
                [$node_id]
            );

        $result = self::getDb()->cache(function ($db) use ($children){
            return self::find()->select('id, tree, lft, name, depth')->
            where(['NOT IN', 'id', $children])->
            orderBy('tree, lft, position')->
            all();
        });

        return $result;
    }

    /**
     * @param   int  $node_id
     * Формирование иерархического списка категорий для Select2
     * @return array
     */
    public static function makeOptionsList($node_id = 0)
    {
        $options = [];
        foreach (self::getTree($node_id) as $row)
            $options[$row->id] = str_repeat('-', $row->depth) . $row->name;

        return $options;
    }

    /**
     * @param   int  $node_id
     * Формирование иерархического массива категорий для Dropdown меню
     * @return array
     */
    public static function makeDropList($node_id = 0)
    {
        $items = [];
        $current_depth = 0;
        $current_path = [0];
        // танцы с бубном для формирования вложенного массива категорий за один проход
        foreach (self::getTree($node_id) as $row) {
            if($row->depth > $current_depth) {
                $current_path[] = 'items';
                $current_path[] = 0;
            } elseif ($row->depth == $current_depth) {
                $index = count($current_path) - 1;
                $current_path[$index]++;
            } else {
                $d = $row->depth - $current_depth;
                array_splice($current_path, 2*$d);
                $index = count($current_path) - 1;
                $current_path[$index]++;
            }
            $current_depth = $row->depth;

            $value = [
                'label' => $row->name,
                'url'   => ['adverts/category', 'id' => $row->id]
            ];

            self::set_recursive($items, $current_path, $value);
        }

        return $items;
    }

    private static function set_recursive(&$array, $path, $value)
    {
        $key = array_shift($path);
        if (empty($path)) {
            $array[$key] = $value;
        } else {
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = array();
            }
            self::set_recursive($array[$key], $path, $value);
        }
    }
}
