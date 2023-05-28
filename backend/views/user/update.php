<?php

/** @var yii\web\View $this */
/* @var  model\forms\manage\User\UserEditForm $model*/
/* @var model\entities\User\ $user */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Оновити ' . $user->username;

$this->params['breadcrumbs'][] = ['label' => 'Користувачі', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Оновити';
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'username')->textInput(['maxLength' => true]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxLength' => true]) ?>
                    <?= $form->field($model, 'password')->passwordInput(['maxLength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ">
                    <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
