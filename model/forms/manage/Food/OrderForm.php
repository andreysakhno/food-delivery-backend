<?php

namespace model\forms\manage\Food;

use model\entities\Food\Order;
use Yii;
use yii\base\Model;
use yii\helpers\Json;


class OrderForm extends Model
{
    public $client_name;
    public $email;
    public $phone;
    public $adress;
    public $products;

    private $_order;

    public function __construct($client_name, $email, $phone, $adress, $products)
    {
        $this->client_name = $client_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->adress = $adress;
        $this->products = Json::encode($products);
    }

    public function rules(): array
    {
        return [
            [['client_name', 'email', 'phone', 'adress', 'products'], 'required'],
            [['client_name', 'email', 'phone', 'adress'], 'string', 'max' => 255],
            [['client_name', 'email', 'phone', 'adress', 'products'], 'trim'],
            ['email', 'email'],
        ];
    }
}