<?php

namespace backend\modules\auth\assets;

use yii\web\AssetBundle;

/**
 * AuthAsset is an asset bundle for [[backend\modules\auth\widgets\AuthChoice]] widget.
 */
class AuthAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/auth/assets/source';
    public $css = [
        'authstyle.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
