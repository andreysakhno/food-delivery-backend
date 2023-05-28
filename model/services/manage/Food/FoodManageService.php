<?php

namespace model\services\manage\Food;

use model\entities\Food\Food;
use model\forms\manage\Food\FoodForm;
use model\repositories\Food\FoodRepository;
use model\repositories\Food\ShopRepository;
use Yii;
use yii\helpers\FileHelper;

class FoodManageService
{
    private $foods;
    private $shops;

    public function __construct(
        FoodRepository $foods,
        ShopRepository $shops
    )
    {
        $this->foods = $foods;
        $this->shops = $shops;
    }

    public function create(FoodForm $form): Food
    {
        $shop = $this->shops->get($form->shopId);

        $food = Food::create(
            $shop->id,
            $form->title,
            $form->price,
            $form->photo,
        );

        $this->foods->save($food);

        return $food;
    }

    public function edit($id, FoodForm $form): void
    {
        $food = $this->foods->get($id);
        $shop = $this->shops->get($form->shopId);

        $food->edit(
            $shop->id,
            $form->title,
            $form->price,
            $form->photo,
        );

        $this->foods->save($food);
    }

    public function activate($id): void
    {
        $food = $this->foods->get($id);
        $food->activate();
        $this->foods->save($food);
    }

    public function draft($id): void
    {
        $food = $this->foods->get($id);
        $food->draft();
        $this->foods->save($food);
    }

    public function removePhoto($id): void
    {
        $food = $this->foods->get($id);

        if ( $food->removePhoto() ) {
            FileHelper::removeDirectory(Yii::getAlias('@staticRoot') . '/origin/food/' . $food->id);
            FileHelper::removeDirectory(Yii::getAlias('@staticRoot') . '/cache/food/' . $food->id);
        }
    }


    public function remove($id): void
    {
        $food = $this->foods->get($id);
        FileHelper::removeDirectory(Yii::getAlias('@staticRoot') . '/origin/food/' . $food->id);
        FileHelper::removeDirectory(Yii::getAlias('@staticRoot') . '/cache/food/' . $food->id);
        $this->foods->remove($food);
    }
}