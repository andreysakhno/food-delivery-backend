<?php

use model\entities\Food\Shop;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Food\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
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
                                'sort',
                                [
                                    'attribute' => 'title',
                                    'value' => function (Shop $model) {
                                        return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                                    },
                                    'format' => 'raw',
                                ],
                                [
                                    'value' => function (Shop $model) {
                                        return
                                            Html::a('<span class="fa fa-arrow-up"></span>', ['move-up', 'id' => $model->id], [
                                                'class'=>'arrows',
                                                'data-method' => 'post',
                                            ]) .
                                            Html::a('<span class="fa fa-arrow-down"></span>', ['move-down', 'id' => $model->id], [
                                                'class'=>'arrows',
                                                'data-method' => 'post',
                                            ]);
                                    },
                                    'format' => 'raw',
                                    'contentOptions' => ['style' => 'text-align: center'],
                                ],
                                'coords',
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
