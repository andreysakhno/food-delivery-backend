<?php

namespace model\repositories\Food;

use model\entities\Food\Order;
use model\repositories\NotFoundException;

class OrderRepository
{
    public function get($id): Order
    {
        if (!$order = Order::findOne($id)) {
            throw new NotFoundException('Не знайдено');
        }
        return $order;
    }

    public function save(Order $order): void
    {
        if (!$order->save()) {
            throw new \RuntimeException('Помилка при збереженні');
        }
    }

    public function remove(Order $order): void
    {
        if (!$order->delete()) {
            throw new \RuntimeException('Помилка при видаленні');
        }
    }
}