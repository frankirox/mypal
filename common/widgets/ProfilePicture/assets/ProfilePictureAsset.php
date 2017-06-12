<?php

namespace common\widgets\ProfilePicture\assets;

use yii\web\AssetBundle;

class ProfilePictureAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/ProfilePicture/assets/src/';
    public $css = [
        'css/imgSelect.css',
    ];
    public $js = [
        'js/webcam.min.js',
        'js/imgSelect.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}