<?php

use model\entities\User\User;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\forms\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Користувачі';
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
                                    'id',
                                    [
                                        'attribute' => 'created_at',
                                        'filter' => DatePicker::widget([
                                            'model' => $searchModel,
                                            'attribute' => 'date_from',
                                            'attribute2' => 'date_to',
                                            'type' => DatePicker::TYPE_RANGE,
                                            'separator' => '-',
                                            'pluginOptions' => [
                                                'todayHighlight' => true,
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd',
                                            ],
                                        ]),
                                        'format' => 'datetime',
                                    ],
                                    [
                                        'attribute' => 'username',
                                        'value' => function (User $model) {
                                            return Html::a(Html::encode($model->username), ['view', 'id' => $model->id]);
                                        },
                                        'format' => 'raw',
                                    ],
                                    'email:email',
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


