<?php

$common = require(__DIR__ . '/common.php');

$config = [
    'id' => getenv('APP_ID') . '-console',

    'controllerNamespace' => 'app\\core\\commands',

    'controllerMap' => [
        'closure-table' => \huijiewei\closuretable\ClosureTableController::class,
    ],

    'components' => [
        'urlManager' => [
            'baseUrl' => getenv('APP_URL'),
        ],
    ],
];

return \yii\helpers\ArrayHelper::merge($common, $config);
