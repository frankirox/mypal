<?php

namespace backend\modules\settings\assets;

use yii\web\AssetBundle;

/**
 * SettingsAsset.
 *
 * @author Franchesco Fonseca <fonseca.franchesco@gmail.com>
 */
class SettingsAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/settings/assets/source';
    public $css = [
        'css/settings.css',
    ];
}