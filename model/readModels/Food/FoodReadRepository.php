<?php

namespace model\readModels\Food;

use model\entities\Food\Food;

class FoodReadRepository
{
    public function find($id): ?Food
    {
        return Food::findOne($id);
    }

    public function getAll($limit = null): array
    {
        return Food::find()->alias('f')->active('f')->orderBy(['title' => SORT_ASC])->limit($limit)->all();
    }

    public function getByShopId($shopIds, $limit = null) : array
    {
        return Food::find()->alias('f')->active('f')->andWhere(['or', ['f.shop_id' => $shopIds]])->orderBy(['title' => SORT_ASC])->limit($limit)->all();
    }
}