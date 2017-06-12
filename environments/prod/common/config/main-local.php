<?php
return [
    'name' => 'MyPal Pet Store',
    /*'bootstrap'  => ['audit'],
    'modules' => [
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            'accessUsers' => [1]
        ],
    ],*/
    'components' => [
        'assetManager' => [
            'forceCopy' => false
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
            'htmlLayout' => '@common/modules/auth/views/mail/layouts/html',
            'textLayout' => '@common/modules/views/mail/layouts/text',
            'useFileTransport' => false,
        ],
    ],
];
