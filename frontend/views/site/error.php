<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Url;

$this->title = $name;
?>
<main class="page404">
    <div class="page404__container">
        <div class="page404__code">404</div>
        <div class="page404__message">
            <p class="page404__text">Вибачте, cторінки, яку ви запросили, немає в нашій базі даних.<br/>
                Швидше за все, ви потрапили на посилання, яке веде на неіснуючу сторінку.</p>
            <a href="<?= Url::home()?>" class="page404__btn primary-btn">Перейти на головну сторінку</a>
        </div>
    </div>
</main>
