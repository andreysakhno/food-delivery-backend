<?php

namespace backend\forms\Food;

use model\entities\Food\Shop;
use model\entities\Food\Food;
use model\helpers\StatusHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class FoodSearch extends Model
{
    public $id;
    public $title;
    public $shop_id;
    public $status;

    public function rules(): array
    {
        return [
            [['id', 'shop_id', 'status'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Food::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'shop_id' => $this->shop_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    public function shopList(): array
    {
        return ArrayHelper::map(Shop::find()->orderBy('sort')->asArray()->all(), 'id', 'title');
    }

    public function statusList(): array
    {
        return StatusHelper::statusList();
    }
}