<?php

namespace model\repositories\Food;

use model\entities\Food\Shop;
use model\repositories\NotFoundException;

class ShopRepository
{
    public function get($id): Shop
    {
        if (!$shop = Shop::findOne($id)) {
            throw new NotFoundException('Магазин не знайдено.');
        }
        return $shop;
    }

    public function getAll(): array
    {
        return Shop::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    public function findByName($title): ?Shop
    {
        return Shop::findOne(['name' => $title]);
    }

    public function save(Shop $shop): void
    {
        if (!$shop->save()) {
            throw new \RuntimeException('Помилка при збереженні.');
        }
    }

    public function remove(Shop $shop): void
    {
        if (!$shop->delete()) {
            throw new \RuntimeException('Помилка при видаленні.');
        }
    }
}