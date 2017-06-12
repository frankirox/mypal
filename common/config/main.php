<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['miranda'],
    'language' => 'en-US',
    'sourceLanguage' => 'en-US',
    'components' => [
        'miranda' => [
            'class' => 'common\components\Miranda',
            'languages' => [
                'en-US' => 'English',
                'es-ES' => 'Español',
            ],
            'languageRedirects' => [
                'en-US' => 'en',
                'es-ES' => 'es',
            ],
            'languageEnableCaching' => true,
            'languageCachingDuration' => 3600,
            'defaultRoles' => ['User']
        ],
        /*'session' => [
            'class' => 'yii\web\DbSession',
        ],*/
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'common\components\User',
            'on afterLogin' => function ($event) {
                \common\models\UserVisitLog::newVisitor($event->identity->id);
            },
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_3Wf6H9ZVTAhYV6yYZVMM6cqG'
            ],
        ],
        'settings' => [
            'class' => 'common\components\Settings'
        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
    ],
];
