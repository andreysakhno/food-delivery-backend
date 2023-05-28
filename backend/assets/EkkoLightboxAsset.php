<?php
namespace backend\assets;

use yii\web\AssetBundle;

class EkkoLightboxAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/ekko-lightbox';

    public $css = [
        'ekko-lightbox.css'
    ];
    public $js = [
        'ekko-lightbox.js'
    ];

    public $depends = [];
}