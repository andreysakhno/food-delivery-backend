<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="error-page">
    <div class="error-content">
        <blockquote class="quote-warning">
            <h6>404</h6>
            <p>
                <?= nl2br(Html::encode($message)) ?>
            </p>
            <p>
                <?= Html::a('Return to home page', Yii::$app->homeUrl); ?>
            </p>
        </blockquote>
    </div>
</div>