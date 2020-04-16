<?php

$common = require(__DIR__ . '/common.php');

$config = [
    'id' => getenv('APP_ID') . '-web',

    'aliases' => [
        '@bower' => dirname(__DIR__) . '/node_modules',
        '@npm' => dirname(__DIR__) . '/node_modules',
    ],

    'components' => [
        'request' => [
            'class' => \app\core\components\WebRequest::class,
            'cookieValidationKey' => getenv('APP_COOKIE_VALIDATION_KEY'),
        ],
    ]
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';

    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];
}

return \yii\helpers\ArrayHelper::merge($common, $config);
