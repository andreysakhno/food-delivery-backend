<?php

namespace model\repositories\Food;

use model\entities\Food\Food;
use model\repositories\NotFoundException;

class FoodRepository
{
    public function get($id): Food
    {
        if (!$food = Food::findOne($id)) {
            throw new NotFoundException('Не знайдено');
        }
        return $food;
    }

    public function existsByShop($id): bool
    {
        return Food::find()->andWhere(['shop_id' => $id])->exists();
    }

    public function save(Food $food): void
    {
        if (!$food->save()) {
            throw new \RuntimeException('Помилка при збереженні');
        }
    }

    public function remove(Food $food): void
    {
        if (!$food->delete()) {
            throw new \RuntimeException('Помилка при видаленні');
        }
    }
}