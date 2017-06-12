<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'api',
    'homeUrl' => '/api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['miranda','log'],
    'on beforeAction' => function($event){

        Yii::$app->view->registerMetaTag([
            'name' => 'robots',
            'content' => "NOINDEX, NOFOLLOW" ]);

    },
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'request' => [
            'baseUrl' => '/api',
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        /*'assetManager' => [
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
            'class'           => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'GET,HEAD v1/pet/' => 'v1/pet/index',
                'GET,HEAD v1/pet/<id:\d+>' => 'v1/pet/view',
                'POST v1/pet/' => 'v1/pet/create',
                'PATCH,PUT v1/pet/<id:\d+>' => 'v1/pet/update',
                'DELETE v1/pet/<id:\d+>' => 'v1/pet/delete',
            ]
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
        'response' => [
            'format' => 'json'
        ]
    ],
    'params' => $params,
];
