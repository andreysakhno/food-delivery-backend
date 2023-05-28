<?php

namespace model\forms\manage\Food;

use model\entities\Food\Shop;
use model\entities\Food\Food;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class FoodForm extends Model
{
    public $shopId;
    public $title;
    public $price;

    public $photo;

    private $_food;

    public function __construct(Food $food = null)
    {
        if ($food) {
            $this->shopId = $food->shop_id;
            $this->title = $food->title;
            $this->price = $food->price;
            $this->_food = $food;
        }
    }

    public function attributeLabels()
    {
        return [
            'shop_id' => 'Ресторан',
            'title' => 'Назва їжі',
            'price' => 'Ціна',
        ];
    }

    public function rules(): array
    {
        return [
            [['shopId', 'title', 'price'], 'required'],
            [['shopId'], 'integer'],
            [['title'], 'string', 'max' => 255],
            ['price', 'number'],
            [['title'], 'trim'],
        ];
    }

    public function shopList(): array
    {
        return ArrayHelper::map(Shop::find()->orderBy('sort')->asArray()->all(), 'id', 'title');
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }
        return false;
    }
}