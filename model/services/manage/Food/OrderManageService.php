<?php

namespace model\services\manage\Food;

use model\entities\Food\Order;
use model\forms\manage\Food\OrderForm;
use model\repositories\Food\OrderRepository;
use Yii;
use yii\helpers\FileHelper;

class OrderManageService
{
    private $orders;

    public function __construct(
        OrderRepository $orders
    )
    {
        $this->orders = $orders;
    }

    public function create(OrderForm $form): Order
    {
        $order = Order::create(            
            $form->client_name,
            $form->email,
            $form->phone,
            $form->adress,
            $form->products
        );

        $this->orders->save($order);
        return $order;
    }



    public function activate($id): void
    {
        $order = $this->orders->get($id);
        $order->activate();
        $this->orders->save($order);
    }

    public function draft($id): void
    {
        $order = $this->orders->get($id);
        $order->draft();
        $this->orders->save($order);
    }



    public function remove($id): void
    {
        $order = $this->orders->get($id);
        $this->orders->remove($order);
    }
}