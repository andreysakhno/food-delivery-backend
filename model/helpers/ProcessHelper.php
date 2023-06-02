<?php

namespace model\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ProcessHelper
{
    public static function processList(): array
    {
        return [
            0 => 'В процесі',
            1 => 'Виконано',
        ];
    }

    public static function processName($status): string
    {
        return ArrayHelper::getValue(self::processList(), $status);
    }

    public static function processLabel($status): string
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

        return Html::tag('span', ArrayHelper::getValue(self::processList(), $status), [
            'class' => $class,
        ]);
    }
}