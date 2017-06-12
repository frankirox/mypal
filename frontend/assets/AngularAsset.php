<?php
namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $js = [
        'js/lib/angular.js',
        'js/lib/angular-route.js',
        'js/lib/angular-strap.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}
