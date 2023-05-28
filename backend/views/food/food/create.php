<?php

use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model model\forms\manage\Food\FoodForm */

$this->title = 'Створити';
$this->params['breadcrumbs'][] = ['label' => 'Їжа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data']
            ]); ?>

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
                            <?= $form->field($model, 'shopId')->dropDownList($model->shopList(), ['prompt' => '']) ?>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 p-3">
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 p-3">
                            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>

                <!-- /.card-body -->
            </div>
            <!-- /.card -->


            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Фотографія</h3>
                    <div class="card-tools">
                        <!-- Collapse Button -->
                        <button type="button" class="btn btn-tool " data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 p-3 image-preview">
                            <div class="image-preview__thumbnails"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 p-3">
                            <?=  $form->field($model, 'photo')->widget(FileInput::class, [
                                'options' => [
                                    'accept' => 'image/png, image/gif, image/jpeg',
                                    'multiple' => false,
                                ],
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'removeClass' => 'btn btn-danger',
                                    'removeIcon' => '<i class="fas fa-trash"></i>',
                                    'showCancel' => false,
                                    'showClose' => false,
                                    'showPreview' => false,
                                    'maxFileSize'=> Yii::$app->params['imageMaxFilesizeKB'],
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <?php
            $script = <<< JS
                    $('#newsform-photo').on('change', function(e) {  
                       $('.image-preview').show();
                       $('.image-preview__thumbnails').html('');
                       const files = this.files;                        
                       for (let i = 0; i < files.length; i++) {
                          let src_url =  window.URL.createObjectURL(files[i]);                           
                          $('.image-preview__thumbnails').append(
                              `<div class="image-preview__thumbnail">
                                    <div class="image-preview__image">
                                        <img src="` + src_url + `" />
                                    </div>                                                                    
                              </div>`);
                       }                 
                    });
                    
                    $('#newsform-photo').on('fileerror', function(event, data, msg) {
                       $('.image-preview').show();
                       $('.image-preview__thumbnails').html('<span class="error-message">' + msg + '</span>');
                    });

                    $('#newsform-photo').on('filecleared', function(event) {                        
                        $('.image-preview__thumbnails').html('');
                        $('.image-preview').hide();
                    });
                    
                    JS;
            $this->registerJs($script, View::POS_END);
            ?>


            <div class="row">
                <div class="col-md-12">
                    <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success submit-btn']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>