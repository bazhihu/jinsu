<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'alipay' => [
            'basePath' => '@app/modules/alipay',
            'class' => 'api\modules\alipay\Module'
        ],
        'wechat' => [
            'basePath' => '@app/modules/wechat',
            'class' => 'api\modules\wechat\Module'
        ],
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module'
        ],
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['api'],
                    'logFile' => '@app/runtime/logs/api.log'
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['wechat'],
                    'logFile' => '@app/runtime/logs/wechat.log'
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'alipay/notify',
                        'alipay/notifywap',
                    ],
                    'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'except' => ['delete']
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'wechat/notify',
                    ],
                    'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'except' => ['delete']
                ],
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                        'v1/login',
                        'v1/country',
                        'v1/user',
                        'v1/order',
                        'v1/config',
                        'v1/pay',
                        'v1/sms',
                        'v1/worker',
                        'v1/wallet',
                        'v1/comment',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'except' => ['delete']
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v2/worker',
                        'v2/wallet',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'except' => ['delete']
                ]
            ],        
        ]
    ],
    'params' => $params,
];



