<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model model\forms\manage\Food\ShopForm */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row mb-3">
    <div class="col-md-12 view">
        <div>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'coords')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 ">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

