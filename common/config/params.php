<?php
return [
    'maintenance' => false,
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'sessionTimeoutSeconds' => '86400',
    'user.passwordResetTokenExpire' => 7200,
    'defaultTimezone' => 'America/Monterrey',
    /*
    * Allowed date formats:
    * medium,long,full,yyyy-MM-dd,dd/MM/yyyy,MM/dd/yyyy,dd.MM.yyyy
   */
    'defaultDateFormat' => 'yyyy-MM-dd',
    /*
     * Allowed time formats:
     * h:mm a,hh:mm a,HH:mm,H:mm
    */
    'defaultTimeFormat' => 'HH:mm',
    'defaultLanguage' => 'es-ES',
    'defaultCountry' => 'MX',
    'defaultPageSize' => 25,
    'version' => '0.1-a',
    'languages' => [
        'en-US' => 'English',
        'es-ES' => 'Español',
    ],
    'languageRedirects' => [
        'en-US' => 'en',
        'es-ES' => 'es',
    ],
    'phoneFormat' => ['9999-999-9999'], //Please refer to http://demos.krajee.com/masked-input to configure the input as need it.
    'merchantIdFormat' => ['A-9{1,8}-9{1}'], //Please refer to http://demos.krajee.com/masked-input to configure the input as need it.
    'documentIdFormat' => ['A-9{1,8}'], //Please refer to http://demos.krajee.com/masked-input to configure the input as need it.
];
