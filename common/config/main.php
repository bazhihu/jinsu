<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
//        'cache' => [
//            'class' => 'yii\redis\Cache',
//        ],
//        'session' => [
//             'class' => 'yii\redis\Session'
//        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.1.20;dbname=youaiyihu',
            'username' => 'youaiyihu',
            'password' => '12345678',
            'charset' => 'utf8',
            'tablePrefix' => 'yayh_'
        ]
    ],
];
