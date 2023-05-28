<?php

namespace model\entities\queries;

use yii\db\ActiveQuery;

class ProcessStatusQuery extends ActiveQuery
{
    const STATUS_DONE = 1;

    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => self::STATUS_DONE,
        ]);
    }
}