<?php
/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <title>Замовлення доставки їжі</title>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">

     <?php $this->head() ?>

    <!-- <style>body{opacity: 0;}</style> -->
    <link rel="shortcut icon" href="favicon.ico">
    <!-- <meta name="robots" content="noindex, nofollow"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
    <header class="header">
        <div class="header__container">
            <div class="header__menu menu">
                <nav class="menu__body">
                    <ul class="menu__list">
                        <li class="menu__item active">
                            <a href="<?= Url::home(); ?>" class="menu__link">Магазин</a>
                        </li>
                        <!--
                        <li class="menu__item"><a href="history.html" class="menu__link">Історія замовлень</a></li>
                        <li class="menu__item"><a href="coupones.html" class="menu__link">Купони</a></li>
                        //-->
                    </ul>
                </nav>
                <button type="button" class="menu__icon icon-menu"><span></span></button>
            </div>
            <a href="<?=Url::to('cart', true); ?>" class="header__cart"></a>
        </div>
    </header>
    <?= $content ?>
    <footer class="footer">
        <div class="footer__container">
            <div class="footer__copyright">2023 &copy; App замовлення доставки їжі</div>
        </div>
    </footer>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
