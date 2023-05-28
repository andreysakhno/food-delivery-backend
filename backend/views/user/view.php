<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var model\entities\User\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Користувачі', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-12">
        <?= Html::a('Оновити', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви впевнені, що хочете видалити цей елемент?',
                'method' => 'post',
            ],
        ]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username',
                        'email:email',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
