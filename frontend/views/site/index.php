<?php
/** @var yii\web\View $this */

$this->title = '';

$this->registerMetaTag(['name' =>'description', 'content' => ""]);
$this->registerMetaTag(['name' =>'keywords', 'content' => ""]);
?>

<main id="shop-page" class="shop">
    <section class="shop__top shop-top">
        <div class="shop-top__container">
            <h1 class="shop-top__title">Магазин</h1>
        </div>
    </section>
    <section class="shop__main shop-main">
        <div class="shop-main__container">
            <div class="shop-main__filters filters">
                <h4 class="filters__title">Ресторани:</h4>
                <ul class="filters__list"></ul>
            </div>
            <div class="shop-main__products products-list"></div>
        </div>
    </section>
</main>