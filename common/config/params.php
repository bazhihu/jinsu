<?php
$serverName = $_SERVER['SERVER_NAME'] ; //图片服务器
$picDomain = null;
if($serverName=='admin.youaiyihu.com')
    $picDomain = 'admin.youaiyihu.com';
if($serverName=='uat.admin.youaiyihu.com')
    $picDomain = 'uat.img.youaiyihu.com';
if($serverName=='sit.admin.youaiyihu.com')
    $picDomain = 'sit.admin.youaiyihu.com';
if($serverName=='dev.admin.youaiyihu.com')
    $picDomain = 'dev.admin.youaiyihu.com';
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'pic_domain' =>$picDomain, //图片服务器
    'aliPay' => [
        'partner' => '2088911035311653',
        'seller_email' => 'pay@youaiyihu.com',
        'ali_public_key_path' => 'alipay_public_key.pem',
        'private_key_path' => 'rsa_private_key.pem',
        'sign_type' => 'RSA',
        'input_charset' => 'utf-8',
        'cacert' => 'alipay_cacert.pem',
        'transport' => 'http'
    ]
];