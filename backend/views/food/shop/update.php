<?php

/* @var $this yii\web\View */
/* @var $shop model\entities\Food\Shop */
/* @var $model model\forms\manage\Food\ShopForm */

$this->title = 'Оновити: ' . $shop->title;
$this->params['breadcrumbs'][] = ['label' => 'Галузі', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $shop->title, 'url' => ['view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = 'Оновити';
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>
    </div>
</div>