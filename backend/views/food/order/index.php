<?php

use model\entities\Food\Order;
use model\helpers\ProcessHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Food\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Замовлення';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    'id',
                                    'client_name',
                                    'email',
                                    'phone',
                                    'adress',
                                    [
                                        'attribute' => 'status',
                                        'filter' => $searchModel->processList(),
                                        'value' => function (Order $model) {
                                            return ProcessHelper::processLabel($model->status);
                                        },
                                        'format' => 'raw',
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template'=>'{view} {delete}'
                                    ]
                                ],
                            ]); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
