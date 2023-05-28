<?php

use model\entities\Food\Food;
use model\helpers\StatusHelper;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Food\FoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Їжа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-5">
                        <div class="col-md-12">
                            <?= Html::a('Створити', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    [
                                        'attribute' => 'title',
                                        'value' => function (Food $model) {
                                            return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                                        },
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'shop_id',
                                        'label' => "Ресторани",
                                        'filter' => $searchModel->shopList(),
                                        'value' => 'shop.title',
                                    ],
                                    'price',
                                    [
                                        'attribute' => 'status',
                                        'filter' => $searchModel->statusList(),
                                        'value' => function (Food $model) {
                                            return StatusHelper::statusLabel($model->status);
                                        },
                                        'format' => 'raw',
                                    ],
                                    ['class' => ActionColumn::class],
                                ],
                            ]); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
