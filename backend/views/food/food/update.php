<?php

use kartik\widgets\FileInput;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $food model\entities\Food\Food */
/* @var $model model\forms\manage\Food\FoodForm */

$this->title = 'Оновити ' . $food->title;
$this->params['breadcrumbs'][] = ['label' => 'Їжа', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $food->title, 'url' => ['view', 'id' => $food->id]];
$this->params['breadcrumbs'][] = 'Оновити';
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
                    <?php if(trim($food->photo)): ?>
                    <div class="row preview_row">
                        <div class="col-md-12 p-3">
                            <div class="image-uploaded__thumbnails">
                                    <div class="image-uploaded__thumbnail">
                                        <div class="image-uploaded__image">
                                            <?= model\widgets\ImgOpt::widget([
                                                "lightbox_data" => "lightbox",
                                                "lightbox_src" => $food->getUploadedFilePath('photo'),
                                                "lightbox_title" => $food->title,
                                                "src" => $food->getThumbFilePath('photo', 'thumb'),
                                                "alt" => $food->title,
                                                "loading" => "lazy"]);
                                            ?>
                                        </div>
                                        <div class="image-uploaded__control justify-content-center" >
                                            <?= Html::button('<span class="fa fa-trash"></span>',
                                                [
                                                    'class' => 'remove-photo btn btn-default',
                                                    'data-id' => $food->id,
                                                ]
                                            );
                                            ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $urlDelete = Url::to(['delete-photo']);
                    $script = <<< JS
                             $('.remove-photo').on('click', function(e) {
                                if(confirm("Ви впевнені, що хочете видалити цей елемент?")) {
                                    const id = $(this).data('id');
                                    const data = {id: id}; 
                                    
                                    const parent_block = $(this).parent().parent();
                                    parent_block.children().hide();                            
                                    parent_block.append('<div class="spinner-border text-danger" role="status"><span class="sr-only">Loading...</span></div>');
                                    
                                    $.ajax({
                                       url: '$urlDelete',
                                       type: 'post',
                                       data: data,
                                       success: function(data) {
                                           console.log(data);
                                           $('.preview_row').remove();
                                           $('.news-photo-input').show();
                                       },
                                       error: function (xhr, ajaxOptions, thrownError) {
                                            console.log(xhr.status);
                                            console.log(thrownError);
                                            parent_block.children().show();
                                            $('.spinner-border').remove();
                                       }
                                    });
                                }
                            });
                            JS;
                    $this->registerJs($script, View::POS_END);
                    ?>
                    <?php  endif; ?>

                    <div class="row <?= trim($food->photo) ? 'news-photo-input' : ''; ?>">
                        <div class="col-md-12 p-3 image-preview">
                            <div class="image-preview__thumbnails"></div>
                        </div>
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
                       $('.image-preview').show('');
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
                    <?= Html::submitButton('Зберегти', ['class' => 'submit-btn btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
