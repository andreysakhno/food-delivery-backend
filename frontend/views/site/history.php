<?php
/** @var yii\web\View $this */

$this->title = 'Історія замовлень';

$this->registerMetaTag(['name' =>'description', 'content' => ""]);
$this->registerMetaTag(['name' =>'keywords', 'content' => ""]);
?>

<main id="history-page" class="shop history">
    <section class="shop__top shop-top">
        <div class="shop-top__container">
            <h1 class="shop-top__title">Історія замовлень</h1>
        </div>
    </section>
    <section class="history__main history-main">
        <div class="history-main__container">
            <form id="form-search"  action="#" method="post">
                <div class="history-main__search form-search">
                    <div class="form-search__inputs">
                        <div class="form-search__item">
                            <label for="email" class="form-search__label">Електронна адреса</label>
                            <input class="form-search__input" autocomplete="off" type="text" name="form[email]" id="email" data-error="Невірна електронна адреса" placeholder="Введіть електронну адресу" >
                        </div>
                        <div class="form-search__item">
                            <label for="phone" class="form-search__label">Телефон</label>
                            <input class="form-search__input" autocomplete="off" type="text" name="form[phone]" id="phone" placeholder="Введіть номер телефону" >
                        </div>
                    </div>
                </div>
            </form>
            <div class="history-main__orders orders"></div>
        </div>
    </section>
</main>