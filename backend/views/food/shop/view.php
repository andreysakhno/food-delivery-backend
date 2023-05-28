<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $shop model\entities\Food\Shop */

$this->title = $shop->title;
$this->params['breadcrumbs'][] = ['label' => 'Ресторани', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-6">
                <?= Html::a('Оновити', ['update', 'id' => $shop->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Видалити', ['delete', 'id' => $shop->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Ви впевнені, що хочете видалити цей елемент?',
                        'method' => 'post',
                    ],
                ]) ?>
                </div>
                <div class="col-md-6 text-right">
                    <?= Html::a('Ресторани', ['index'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 view">
                    <?= DetailView::widget([
                        'model' => $shop,
                        'attributes' => [
                            'id',
                            'title',
                            'coords',
                            'sort',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>