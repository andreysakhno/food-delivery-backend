<?php

/* @var $this yii\web\View */
/* @var $model model\forms\manage\Object\IndustryForm */

$this->title = 'Створити';
$this->params['breadcrumbs'][] = ['label' => 'Галузі', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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