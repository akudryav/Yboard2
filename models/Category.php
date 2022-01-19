<?php

namespace app\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\helpers\Url;

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
    public $params_flag = false;
    private static $_tree_pool = [];
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
            [['description', 'fields'], 'string'],
            ['params_flag', 'boolean'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('cat', 'Category name'),
            'tree' => Yii::t('cat', 'Tree'),
            'parentId' => Yii::t('cat', 'Parent'),
            'icon' => Yii::t('cat', 'Icon'),
            'fields' => Yii::t('cat', 'Additional fields'),
            'params_flag' => Yii::t('cat', 'Fields flag'),
            'position' => Yii::t('cat', 'Position'),
            'description' => Yii::t('cat', 'Description'),
        );
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
        if(!isset(self::$_tree_pool[$node_id]))
        {
            // don't include children and the node
            $children = [];

            if ( ! empty($node_id))
            {
                $children = array_merge(
                    self::findOne($node_id)->children()->column(),
                    [$node_id]
                );
            }

            self::$_tree_pool[$node_id] = self::getDb()->cache(
                function ($db) use ($children) {
                    return self::find()->select(
                        'id, tree, lft, rgt, name, depth, fields'
                    )
                        ->where(['NOT IN', 'id', $children])
                        ->orderBy('tree, lft, position')
                        ->indexBy('id')
                        ->asArray()->all();
                }
            );
        }

        return self::$_tree_pool[$node_id];
    }

    /**
     * Формирование списка дочерних категорий текущей для выпадающего списка
     * @return array
     */
    public function makeChildList()
    {
        $options = [];
        $children = $this->children()->all();
        if (!$children) {
            $options[$this->id] = $this->name;
        } else {
            foreach ($children as $row)
                $options[$row['id']] = $row['name'];
        }

        return $options;
    }

    /**
     * Формирование списка дочерних категорий содержащего текущую
     * @return array
     */
    public function makeRootList()
    {
        $options = [];
        $parent = $this->parents(1)->one();
        if (!$parent) {
            $options[$this->id] = $this->name;
        } else {
            $options = $parent->makeChildList();
        }

        return $options;
    }

    /**
     * @param int $node_id
     * Формирование иерархического списка категорий для Select2
     * @return array
     */
    public static function makeOptionsList($node_id = 0)
    {
        $options = [];
        foreach (self::getTree($node_id) as $row)
            $options[$row['id']] = str_repeat('-', $row['depth']) . $row['name'];

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
            if ($row['depth'] > $current_depth) {
                $current_path[] = 'items';
                $current_path[] = 0;
            } elseif ($row['depth'] == $current_depth) {
                $index = count($current_path) - 1;
                $current_path[$index]++;
            } else {
                $d = $row['depth'] - $current_depth;
                array_splice($current_path, 2 * $d);
                $index = count($current_path) - 1;
                $current_path[$index]++;
            }
            $current_depth = $row['depth'];

            $value = [
                'label' => $row['name'],
                'url' => Url::to(['adverts/category', 'id' => $row['id']]),
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

    public static function toUL($array, $first_level = true){
        $menu = '';
        $has_sub = false;
        foreach($array as $member){
            //check for value member
            if(!isset($member['items']) ){
                //if value is present, echo it in an li
                $menu .=  "<li><a href='{$member['url']}'>{$member['label']}</a></li>\n";
            } else {
                $has_sub = true;
                //if the member is another array, start a fresh li
                $menu .=  "<li><a href='#'> {$member['label']}</a>\n";
                //and pass the member back to this function to start a new ul
                $menu .= self::toUL($member['items'], false);
                //then close the li
                $menu .=  "</li>\n";
            }
        }
        $class = $has_sub ? 'has_sub' : 'not_sub';
        if($first_level) $class = 'categories-menu__list';
        $menu = "<ul class='$class'>\n".$menu."</ul>\n";
        return $menu;
    }

    public static function fieldData($category_id)
    {
        $cat = self::getTree()[$category_id];
        if (trim($cat['fields']) == '') return null;
        return unserialize($cat['fields']);
    }

    public function fieldNames()
    {
        $result = [];
        foreach (self::fieldData($this->id) as $field) {
            $result[] = $field['name'];
        }
        return implode(', ', $result);
    }
}
