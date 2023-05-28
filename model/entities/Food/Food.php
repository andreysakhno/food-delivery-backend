<?php

namespace model\entities\Food;

use model\entities\queries\ActiveStatusQuery;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property integer $shop_id
 * @property string $title
 * @property boolean $price
 * @property string $photo
 * @property integer $status
 *
 * @property Shop $shop
 */

class Food extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($shopId, $title, $price, $photo): self
    {
        $food = new static();
        $food->shop_id = $shopId;
        $food->title = $title;
        $food->price = $price;
        $food->photo = $photo;
        $food->status = self::STATUS_DRAFT;
        return $food;
    }

    public function edit ($shopId, $title, $price, $photo): void
    {
        $this->shop_id = $shopId;
        $this->title = $title;
        $this->price = $price;
        $this->photo = $photo;
    }

    public function attributeLabels()
    {
        return [
            'shop_id' => 'Ресторан',
            'title' => 'Назва їжі',
            'price' => 'Ціна',
            'photo' => 'Фотографія',
            'status' => "Статус",
        ];
    }

    ##########################

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Запис вже має статус "активний".');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Запис вже має статус "чернетка"');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    ##########################

    public function getShop(): ActiveQuery
    {
        return $this->hasOne(Shop::class, ['id' => 'shop_id']);
    }

    public function removePhoto(): bool
    {
        return Yii::$app->db->createCommand()->update($this->tableName(), ['photo' => null], "id = {$this->id}")->execute();
    }

    ##########################

    public static function tableName(): string
    {
        return '{{%foods}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => false,
                'filePath' => '@staticRoot/origin/food/[[attribute_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/food/[[attribute_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/food/[[attribute_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/food/[[attribute_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'gallery' => ['width' => 900, 'height' => 450],
                    'thumb' => ['width' => 500, 'height' => 420],
                ],
            ],
        ];
    }

    public static function find(): ActiveStatusQuery
    {
        return new ActiveStatusQuery(static::class);
    }
}