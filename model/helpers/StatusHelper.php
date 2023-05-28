<?php

namespace model\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class StatusHelper
{
    public static function statusList(): array
    {
        return [
            0 => 'Чернетка',
            1 => 'Активний',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case 0:
                $class = 'badge bg-danger';
                break;
            case 1:
                $class = 'badge bg-success';
                break;
            default:
                $class = 'badge bg-danger';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}