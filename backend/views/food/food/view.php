<?php

use model\helpers\StatusHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $food model\entities\Food\Food */

$this->title = $food->title;
$this->params['breadcrumbs'][] = ['label' => 'Їжа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row mb-5">
                <div class="col-md-6">
                    <?php if ($food->isActive()): ?>
                        <?= Html::a('Чернетка', ['draft', 'id' => $food->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
                    <?php else: ?>
                        <?= Html::a('Активувати', ['activate', 'id' => $food->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
                    <?php endif; ?>
                    <?= Html::a('Оновити', ['update', 'id' => $food->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Видалити', ['delete', 'id' => $food->id], [
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
                                'model' => $food,
                                'options' => [
                                    'class' => 'table table-bordered detail-view',
                                ],
                                'attributes' => [
                                    'id',
                                    [
                                        'attribute' => 'status',
                                        'value' => StatusHelper::statusLabel($food->status),
                                        'format' => 'raw',
                                    ],
                                    'title',
                                    'price',
                                    [
                                        'label' => 'Ресторани',
                                        'value' => ArrayHelper::getValue($food, 'shop.title'),
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
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
                    <?php endif; ?>

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

                    <?php
                    $script = <<< JS
                        $(function () {
                            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                                event.preventDefault();
                                $(this).ekkoLightbox({
                                    alwaysShowClose: true
                                });
                            });
                        });
                       JS;
                    $this->registerJs($script, View::POS_END);
                    ?>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>