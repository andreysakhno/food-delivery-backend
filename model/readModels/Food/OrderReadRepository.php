<?php

namespace model\readModels\Food;

use model\entities\Food\Order;

class OrderReadRepository
{
    public function find($id): ?Order
    {
        return Order::findOne($id);
    }

    public function getAll($limit = null): array
    {
        return Order::find()->limit($limit)->all();
    }

    public function getByEmailOrPhone($email, $phone, $limit = null): array
    {
        return Order::find()->where(['or', ['email' => $email], ['phone' => $phone]])->limit($limit)->all();
    }
}