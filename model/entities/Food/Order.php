<?php

namespace model\entities\Food;


use model\entities\queries\ProcessStatusQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $client_name
 * @property string $email
 * @property string $phone
 * @property string $adress
 * @property string $products
 * @property integer $status
 */
class Order extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_DONE = 1;

    public static function create($client_name, $email, $phone, $adress, $products): self
    {
        $order = new static();
        $order->client_name = $client_name;
        $order->email = $email;
        $order->phone = $phone;
        $order->adress = $adress;
        $order->products = $products;
        $order->status = self::STATUS_NEW;
        return $order;
    }

    public function attributeLabels()
    {
        return [
            'client_name' => "Ім'я замовника",
            'email' => 'email',
            'phone' => 'Телефон',
            'adress' => 'Адреса',
            'products' => 'Замовлення',
            'status' => 'Cтатус',
        ];
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Запис вже має статус "активний".');
        }
        $this->status = self::STATUS_DONE;
    }

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Запис вже має статус "чернетка"');
        }
        $this->status = self::STATUS_NEW;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_DONE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_NEW;
    }

    public static function tableName(): string
    {
        return '{{%orders}}';
    }

    public static function find(): ProcessStatusQuery
    {
        return new ProcessStatusQuery(static::class);
    }
}