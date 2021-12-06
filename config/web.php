<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db_local.php';

$config = [
    'id' => 'Yboard2',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'name' => 'Шопот',
    'bootstrap' => ['log', 'debug'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@config' => '@app/config',
    ],
    'container' => [
        'definitions' => [
            \yii\widgets\LinkPager::class => \yii\bootstrap4\LinkPager::class,
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
        'moderator' => [
            'class' => 'app\modules\moderator\ModerModule',
        ],
        'lk' => [
            'class' => 'app\modules\lk\LkModule',
            // ... другие настройки модуля ...
        ],
        'yii2images' => [
            'class' => 'rico\yii2images\Module',
            //be sure, that permissions ok
            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
            'imagesStorePath' => '@webroot/images/store', //path to origin images
            'imagesCachePath' => '@webroot/images/cache', //path to resized copies
            'graphicsLibrary' => 'Imagick', //but really its better to use 'Imagick'
            'placeHolderPath' => '@webroot/images/noimage.gif', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ba72a75d2502ab4172156918eb5ea627',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\components\WebUser',
            'identityClass' => 'app\models\User',
            'loginUrl' => ['user/login'],
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'yandexMapsApi' => [
            'class' => 'mirocow\yandexmaps\Api',
            'apikey' => 'fb83dd5c-0b94-49c3-bb41-af2f95def1a8',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm:ss',
            'timeFormat' => 'H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                ],
            ],
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                'category/<id:\d+>' => 'adverts/category',
                'logout' => 'user/logout',
                'login' => 'user/login',
                'cat_fields/<id:\d+>' => 'adverts/getfields',
                'page/<view:\w+>/' => 'site/page',
                '<module:lk>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '172.18.0.1'],
    ];
}

return $config;
