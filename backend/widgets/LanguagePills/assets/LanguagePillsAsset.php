<?php

namespace backend\widgets\LanguagePills\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class LanguagePillsAsset
 *
 * @package common\assets
 */
class LanguagePillsAsset extends AssetBundle
{
    public $sourcePath = '@backend/widgets/LanguagePills/assets/';

    public $js = [
        'js/language.js',
    ];

    public $css = [
        'css/language.css',
    ];

}