<?php
namespace app\models;

use yii\db\ActiveRecord;


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
class MActiveRecord extends ActiveRecord
{

    public function unsetAttributes($names = null)
    {
        if ($names === null)
            $names = $this->attributeNames();
        foreach ($names as $name) {
            if (!empty($name)) {
                $this->$name = null;
            }
        }
    }

    public function attributeNames()
    {
        return $this->attributes;
    }


}
