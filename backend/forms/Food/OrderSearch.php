<?php

namespace backend\forms\Food;

use model\entities\Food\Order;
use model\helpers\ProcessHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class OrderSearch extends Model
{
    public $id;
    public $client_name;
    public $email;
    public $phone;
    public $adress;
    public $status;

    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['client_name', 'email', 'phone', 'adress'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Order::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'adress', $this->adress]);

        return $dataProvider;
    }

    public function processList(): array
    {
        return ProcessHelper::processList();
    }
}