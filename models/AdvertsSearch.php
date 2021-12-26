<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * AdvertsSearch represents the model behind the search form about `common\models\Adverts`.
 */
class AdvertsSearch extends Adverts
{
    public $price_min;
    public $price_max;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'category_id', 'moderated', 'type'], 'integer'],
            [['price_min', 'price_max'], 'number'],
            [['name', 'address', 'text'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $criteria = Adverts::find()->innerJoinWith('category');

        $dataProvider = new ActiveDataProvider([
            'query' => $criteria,
            'pagination' => [
                'pageSize' => Yii::$app->params['adv_on_page'],
            ],
        ]);
        // загружаем данные формы поиска и производим валидацию
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $criteria->andFilterWhere([
            'adverts.id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'moderated' => $this->moderated,
        ]);

        if (is_numeric($this->category_id)) {
            $criteria->andWhere(['OR',
                ['category_id' => $this->category_id],
                ['AND',
                    ['>', 'category.lft', Category::getTree()[$this->category_id]['lft']],
                    ['<', 'category.rgt', Category::getTree()[$this->category_id]['rgt']],
                    ['category.tree' => Category::getTree()[$this->category_id]['tree']]
                ]
            ]);
        }

        if (is_numeric($this->price_min) and $this->price_max > 0) {
            $criteria->andWhere("price >= " . $this->price_min . " and price <= " . $this->price_max);
        }

        $criteria->andFilterWhere(['like', 'address', $this->address]);
        $criteria->andFilterWhere(['like', 'adverts.name', $this->name]);
        $criteria->andFilterWhere(['like', 'text', $this->text]);

        $criteria->orderBy('adverts.id DESC');

        return $dataProvider;
    }
}