<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        'session' => [
             'class' => 'yii\redis\Session'
        ],

    ],
];
