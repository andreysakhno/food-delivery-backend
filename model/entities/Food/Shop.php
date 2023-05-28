<?php

namespace model\entities\Food;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $title
 * @property string $coords
 * @property integer $sort
 */
class Shop extends ActiveRecord
{
    public static function create($title, $coords, $sort): self
    {
        $shop = new static();
        $shop->title = $title;
        $shop->coords = $coords;
        $shop->sort = $sort;
        return $shop;
    }

    public function edit($title, $coords, $sort): void
    {
        $this->title = $title;
        $this->coords = $coords;
        $this->sort = $sort;
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Назва',
            'coords' => 'Координати ресторану',
            'sort' => 'Порядок',
        ];
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public static function tableName(): string
    {
        return '{{%shops}}';
    }
}