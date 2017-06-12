<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'backend',
    'homeUrl' => '/admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['miranda','log'],
    'on beforeRequest' => function ($event) {
        if (Yii::$app->params['maintenance']) {

            if(!Yii::$app->user->isSuperAdmin && !preg_match('%debug/default%',Yii::$app->request->url)){
                Yii::$app->catchAll = [
                    // force route if portal in maintenance mode
                    'site/maintenance',
                ];

            }
        }
    },
    'on beforeAction' => function($event){

        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => "NOINDEX, NOFOLLOW" ]);

        //\bedezign\yii2\audit\web\JSLoggingAsset::register(\Yii::$app->view);

    },
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
        ],
        'auth' => [
            'class' => 'backend\modules\auth\AuthModule',
        ],
        'settings' => [
            'class' => 'backend\modules\settings\SettingsModule',
        ],
        'translation' => [
            'class' => 'backend\modules\translation\TranslationModule',
        ],
        'user' => [
            'class' => 'backend\modules\user\UserModule',
        ],
        'menu' => [
            'class' => 'backend\modules\menu\MenuModule',
        ],
        'pet' => [
            'class' => 'backend\modules\pet\PetModule',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '/admin',
        ],
      /* 'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@backend/assets/bootstrap/',
                    'css' => ['css/bootstrap.min.css']
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => '@backend/assets/bootstrap/',
                    'js' => ['js/bootstrap.min.js']
                ],
            ],
        ],*/
        'urlManager' => [
            'class' => 'backend\components\MultilingualUrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'multilingualRules' => false,
            'rules' => array(
                //add here local frontend controllers
                '<controller:(test)>' => '<controller>/index',
                '<controller:(test)>/<id:\d+>' => '<controller>/view',
                '<controller:(test)>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:(test)>/<action:\w+>' => '<controller>/<action>',
                '<module:auth>/<action:\w+>' => '<module>/default/<action>',
                //Miranda CMS and other modules routes
                '<module:\w+>/' => '<module>/default/index',
                '<module:\w+>/<action:\w+>/<id:\d+>' => '<module>/default/<action>',
                '<module:\w+>/<action:(create)>' => '<module>/default/<action>',
                '<module:\w+>/<controller:\w+>' => '<module>/<controller>/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            )
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            //'class' => '\bedezign\yii2\audit\components\web\ErrorHandler',
        ],
    ],
    'params' => $params,
];
