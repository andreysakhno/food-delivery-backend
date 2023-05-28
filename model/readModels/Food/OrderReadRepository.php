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
}