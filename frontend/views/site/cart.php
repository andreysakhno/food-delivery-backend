<?php
/** @var yii\web\View $this */

$this->title = 'Корзина';

$this->registerMetaTag(['name' =>'description', 'content' => ""]);
$this->registerMetaTag(['name' =>'keywords', 'content' => ""]);
?>

<main id="cart-page" class="shop cart">
    <section class="shop__top shop-top">
        <div class="shop-top__container">
            <h1 class="shop-top__title">Корзина</h1>
        </div>
    </section>
    <form data-goto-error data-dev action="#" method="post">
        <section class="cart__main cart-main">
            <div class="cart-main__container">
                <div class="cart-main__personal form-personal">
                    <h4 class="form-personal__title">Введіть дані для замовлення:</h4>
                    <div class="form-personal__inputs">
                        <div class="form-personal__item">
                            <label for="name" class="form-personal__label">І’мя</label>
                            <input class="form-personal__input" autocomplete="off" type="text" name="form[name]" id="name" data-validate data-required data-error="Заповніть обов’язкове поле" placeholder="Введіть ваше і’мя">
                        </div>
                        <div class="form-personal__item">
                            <label for="email" class="form-personal__label">Електронна адреса</label>
                            <input class="form-personal__input" autocomplete="off" type="text" name="form[email]" id="email" data-validate data-required="email" data-error="Невірна електронна адреса" placeholder="Введіть вашу електронну адресу">
                        </div>
                        <div class="form-personal__item">
                            <label for="phone" class="form-personal__label">Телефон</label>
                            <input class="form-personal__input" autocomplete="off" type="text" name="form[phone]" id="phone" data-validate data-required data-error="Заповніть обов’язкове поле" placeholder="Введіть ваш номер телефону">
                        </div>
                        <div class="form-personal__item">
                            <label for="adress" class="form-personal__label">Адреса</label>
                            <input class="form-personal__input" autocomplete="off" type="text" name="form[adress]" id="adress" data-validate data-required data-error="Заповніть обов’язкове поле" placeholder="Введіть вашу адресу">
                            <div class="form-personal__map-container">
                                <div class="form-personal__map" id="map"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="cart-main__order form-order">
                    <h4 class="form-order__title">Ваше замовлення:</h4>

                    <div class="form-order__list"></div>
                </div>
                <div class="cart-main__submit form-submit">
                    <div class="form-submit_sum">
                        <div class="form-submit_sum-lable">Cума замовлення:</div>
                        <div class="form-submit_sum-totlal">
                            <span class="form-submit_sum-value">1566.50</span>
                            <span class="form-submit_sum-currency">грн.</span>
                        </div>
                    </div>
                    <button type="submit" class="form-submit__btn primary-btn">Замовити</button>
                </div>
            </div>
        </section>
    </form>
</main>