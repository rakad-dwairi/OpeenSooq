<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key' => 'secret',  //typically a long random string
            'jwtValidationData' => \frontend\components\JwtValidationData::class,
        ],
    ],
];
