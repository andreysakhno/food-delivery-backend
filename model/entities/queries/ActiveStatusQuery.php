<?php

namespace model\entities\queries;

use yii\db\ActiveQuery;

class ActiveStatusQuery extends ActiveQuery
{
    const STATUS_ACTIVE = 1;

    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => self::STATUS_ACTIVE,
        ]);
    }
}