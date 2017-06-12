<?php
return [
    'name' => 'Miranda CMS',
    /*'bootstrap'  => ['audit'],
    'modules' => [
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            'accessUsers' => [1]
        ],
    ],*/
    'components' => [
        'assetManager' => [
            'forceCopy' => true
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=miranda',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'yourname@gmail.com',
                'password' => 'yourpassword',
                'port' => '587',
                'encryption' => 'tls',
            ],
            'htmlLayout' => '@common/modules/views/mail/layouts/html',
            'textLayout' => '@common/modules/views/mail/layouts/text',
            'useFileTransport' => true,
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
    ],
];
