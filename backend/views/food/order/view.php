<?php

use model\helpers\ProcessHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $order model\entities\Food\Food */

$this->title = "Замовлення №".$order->id;
$this->params['breadcrumbs'][] = ['label' => 'Замовлення', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-6">
                    <?php if ($order->isActive()): ?>
                        <?= Html::a('Не виконано', ['draft', 'id' => $order->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
                    <?php else: ?>
                        <?= Html::a('Виконано', ['activate', 'id' => $order->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
                    <?php endif; ?>
                    <?= Html::a('Видалити', ['delete', 'id' => $order->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Ви впевнені, що хочете видалити цей елемент?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6 text-right">
                    <?= Html::a('Їжа', ['index'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>


            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Загальні дані</h3>
                    <div class="card-tools">
                        <!-- Collapse Button -->
                        <button type="button" class="btn btn-tool " data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 p-3">
                            <?= DetailView::widget([
                                'model' => $order,
                                'options' => [
                                    'class' => 'table table-bordered detail-view',
                                ],
                                'attributes' => [
                                    'id',
                                    'client_name',
                                    'email',
                                    'phone',
                                    'adress',
                                    [
                                        'attribute' => 'status',
                                        'value' => ProcessHelper::processLabel($order->status),
                                        'format' => 'raw',
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <?php $products = Json::decode($order->products); ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Ресторан</th>
                                <th>Страва</th>
                                <th>Кількість</th>
                                <th>Ціна за одиницю</th>
                                <th>Ціна разом</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $total_price = 0; ?>
                        <?php  foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <?= Html::img($product['src'], ["height" => "100"]);?>
                                </td>
                                <td>
                                    <?= Html::a($product['shopTitle'], ["/food/shop/view", 'id' => $product['shopId']], ["target" => "_blank"]);?>
                                </td>
                                <td>
                                    <?= Html::a($product['title'], ["/food/food/view", 'id' => $product['id']], ["target" => "_blank"]);?>
                                </td>
                                <td>
                                    <?= $product['quantity']; ?>
                                </td>
                                <td>
                                    <?= number_format($product['price'], 2); ?> грн.
                                </td>
                                <td>
                                    <?= number_format($total_price += $product['quantity'] * $product['price'], 2); ?> грн.
                                </td>
                            </tr>
                        <?php  endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" align="right"><strong>РАЗОМ:</strong></td>
                                <td>
                                    <strong><?= number_format($total_price, 2); ?> грн.</strong>
                                </td>
                            </tr>
                        <tfoot>
                    </table>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>