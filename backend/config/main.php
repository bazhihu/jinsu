<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'language'=>'zh-CN',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [

        'gridview' => [
            'class' => 'kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu', // it can be '@path/to/your/layout'.
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'backend\models\AdminUser',
                    'idField' => 'id'
                ],
//                'other' => [
//                    //'class' => 'path\to\OtherController', // add another controller
//                ],
            ],
            'menus' => [
                'assignment' => [
                    'label' => '权限管理' // change label
                ],
                'role' => [
                    'label' => '角色' // change label
                ],
                'permission' => [
                    'label' => '权限' // change label
                ],
                'route' => null, // disable menu route
            ]
        ],
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute
            'displaySettings' => [
                'date' => 'yyyy-MM-dd',
                'time' => 'HH:i:s',
                'datetime' => 'yyyy-MM-dd HH:i:s',
            ],
//
//            // format settings for saving each date attribute
            'saveSettings' => [
                'date' => 'yyyy-MM-dd',
                'time' => 'HH:i:s',
                'datetime' => 'yyyy-MM-dd HH:i:s',
            ],

            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,
            'autoWidgetSettings' => [
                'date' => ['type'=>2, 'pluginOptions'=>['autoclose'=>true,'todayHighlight' => true]], // example
                'time' => ['pluginOptions'=>['autoclose'=>true,'todayHighlight' => true]], // setup if needed
                'datetime' => ['pluginOptions'=>['autoclose'=>true,'todayHighlight' => true]], // setup if needed

            ],

        ]

    ],
    'components' => [
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@vendor/yiisoft/yii2/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'zh-CN',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'backend\models\AdminUser',
            'enableAutoLogin' => true,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'messageConfig' => [
                'from' => ['zhangbo@youaiyihu.com' => 'Admin'], // this is needed for sending emails
                'charset' => 'UTF-8',
            ]
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'yayh_auth_item',
            'assignmentTable' => 'yayh_auth_assignment',
            'itemChildTable' => 'yayh_auth_item_child',
            'defaultRoles' => ['guest']
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/error',
            'site/logout',
            'tq/index'
        ]
    ],
    'params' => $params,
];
