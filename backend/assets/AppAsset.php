<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/vendor/switcher.min.css',
    ];
    public $js = [
        'js/yii_overrides.js',
        'js/vendor/smartresize.js',
        'js/vendor/switcher.min.js',
        //'js/vendor/loadingoverlay.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\GentelellaAsset',
        'backend\assets\CustomGentelellaAsset',
        'backend\modules\auth\assets\AvatarAsset',
        'kartik\select2\Select2Asset',
        'backend\assets\SweetAlertAsset',
        'backend\assets\NotyAsset',
    ];

}
