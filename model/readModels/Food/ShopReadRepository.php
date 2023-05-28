<?php

namespace model\readModels\Food;

use model\entities\Food\Shop;

class ShopReadRepository
{
    public function find($id): ?Shop
    {
        return Shop::findOne($id);
    }

    public function getAll($limit = null): array
    {
        return Shop::find()->orderBy(['sort' => SORT_ASC])->limit($limit)->all();
    }
}