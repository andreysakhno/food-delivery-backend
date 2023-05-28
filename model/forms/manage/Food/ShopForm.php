<?php

namespace model\forms\manage\Food;

use model\entities\Food\Shop;
use Yii;
use yii\base\Model;


class ShopForm extends Model
{
    public $title;
    public $coords;
    public $sort;

    private $_shop;

    public function __construct(Shop $shop = null)
    {
        if ($shop) {
            $this->title = $shop->title;
            $this->coords = $shop->coords;
            $this->sort = $shop->sort;
            $this->_shop = $shop;
        } else {
            $count = Shop::find()->count();
            $this->sort = $count ? $count : 0;
        }
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Назва',
            'coords' => 'Координати ресторану',
            'sort' => 'Порядок',
        ];
    }

    public function rules(): array
    {
        return [
            [['title', 'coords', 'sort'], 'required'],
            [['title', 'coords'], 'string', 'max' => 255],
            [['title'], 'unique', 'targetClass' => Shop::class, 'filter' => $this->_shop ? ['<>', 'id', $this->_shop->id] : null],
            [['title', 'coords'], 'trim'],
            [['sort'], 'integer'],
        ];
    }
}