<?php

namespace model\services\manage\Food;

use model\entities\Food\Shop;
use model\forms\manage\Food\ShopForm;
use model\repositories\Food\FoodRepository;
use model\repositories\Food\ShopRepository;
// use model\repositories\Food\FoodRepository;
use Yii;

class ShopManageService
{
    private $shops;
    private $foods;

    public function __construct(ShopRepository $shops, FoodRepository $foods)
    {
        $this->shops = $shops;
        $this->foods = $foods;
    }

    public function create(ShopForm $form): Shop
    {
        $shop = Shop::create(
            $form->title,
            $form->coords,
            $form->sort
        );
        $this->shops->save($shop);
        return $shop;
    }

    public function edit($id, ShopForm $form): void
    {
        $shop = $this->shops->get($id);
        $shop->edit(
            $form->title,
            $form->coords,
            $form->sort
        );
        $this->shops->save($shop);
    }

    public function moveUp($id): void
    {
        $shops = $this->shops->getAll();

        foreach ($shops as $i => $shop) {
            if ($shop->id == $id) {
                if ($prev = $shops[$i - 1] ?? null) {
                    $shops[$i - 1] = $shop;
                    $shops[$i] = $prev;
                    $this->updateShops($shops);
                }
                return;
            }
        }
        throw new \DomainException('Галузь не знайдено');
    }

    public function moveDown($id): void
    {
        $shops = $this->shops->getAll();
        foreach ($shops as $i => $shop) {
            if ($shop->id == $id) {
                if ($next = $shops[$i + 1] ?? null) {
                    $shops[$i] = $next;
                    $shops[$i + 1] = $shop;
                    $this->updateShops($shops);
                }
                return;
            }
        }
        throw new \DomainException('Галузь не знайдено');
    }

    public function remove($id): void
    {
        $shop = $this->shops->get($id);
        if ($this->foods->existsByShop($shop->id)) {
            throw new \DomainException('Неможливо видалити магазин, що привязаний до товару.');
        }
        $this->shops->remove($shop);
        $shops = $this->shops->getAll();
        $this->updateShops($shops);
    }

    private function updateShops(array $shops): void
    {
        foreach ($shops as $i => $shop) {
            $shop->setSort($i);
            $this->shops->save($shop);
        }
    }
}