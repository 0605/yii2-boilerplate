<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/19
 * Time: 16:15
 */

$db = require(__DIR__ . '/db.php');

$serverTimeZone = getenv('APP_SERVER_TIMEZONE');

return [
    'name' => getenv('APP_NAME'),
    'language' => 'zh-CN',
    'timeZone' => $serverTimeZone,
    'basePath' => dirname(__DIR__) . '/src',
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'runtimePath' => dirname(__DIR__) . '/runtime',

    'bootstrap' => [
        'log',
    ],

    'aliases' => [
        '@app/web' => dirname(__DIR__) . '/public',
        '@app/migrations' => dirname(__DIR__) . '/database/migrations',
    ],

    'modules' => [
        \app\modules\admin\api\Module::getModuleId() => \app\modules\admin\api\Module::class,
        \app\modules\admin\spa\Module::getModuleId() => \app\modules\admin\spa\Module::class,
        \app\modules\website\Module::getModuleId() => \app\modules\website\Module::class,
    ],

    'components' => [
        'db' => $db,

        'user' => [
            'class' => \yii\web\User::class,
            'enableSession' => false,
        ],

        'security' => [
            'passwordHashStrategy' => 'password_hash',
        ],

        'cache' => [
            'class' => getenv('APP_DISABLE_CACHE') ? \yii\caching\DummyCache::class : \yii\caching\FileCache::class,
        ],

        'formatter' => [
            'defaultTimeZone' => $serverTimeZone,
            'timeZone' => $serverTimeZone,
            'dateFormat' => 'yyyy-MM-dd',
            'timeFormat' => 'HH:mm',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm',
            'nullDisplay' => '',
        ],

        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'useFileTransport' => true,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:401',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:403',
                        'yii\web\HttpException:405',
                        'yii\web\HttpException:406',
                        'yii\web\HttpException:422',
                        'yii\web\HttpException:429',
                    ],
                    'logVars' => [],
                ],
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['info'],
                    'categories' => ['debug'],
                    'logFile' => '@runtime/logs/debug.log',
                    'logVars' => [],
                ],
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['info'],
                    'categories' => ['wechat'],
                    'logFile' => '@runtime/logs/wechat.log',
                    'logVars' => [],
                ],
            ]
        ],

        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'rules' => [
                [
                    'class' => \yii\web\GroupUrlRule::class,
                    'prefix' => \app\modules\admin\api\Module::getModuleId(),
                    'rules' => [
                        '' => 'site/index',
                        '<controller>' => '<controller>/index',
                        '<controller>/<action>' => '<controller>/<action>',
                    ],
                ],
                [
                    'class' => \yii\web\GroupUrlRule::class,
                    'prefix' => \app\modules\admin\spa\Module::getModuleId(),
                    'rules' => [
                        '' => 'site/index',
                        '<controller>' => 'site/index',
                        '<controller>/<action>' => 'site/index',
                    ],
                ],
                '' => \app\modules\website\Module::getModuleId() . '/site/index',
                '<controller>' => \app\modules\website\Module::getModuleId() . '/<controller>/index',
                '<controller>/<action>' => \app\modules\website\Module::getModuleId() . '/<controller>/<action>',
            ],
        ],
    ],
];
