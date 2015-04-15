<?php
$server_name = $_SERVER['SERVER_NAME'] ; //图片服务器
$pic_domain = null;
if($server_name=='admin.youaiyihu.com')
    $pic_domain = "admin.youaiyihu.com";
if($server_name=='uat.admin.youaiyihu.com')
    $pic_domain = "uat.img.youaiyihu.com";
if($server_name=='sit.admin.youaiyihu.com')
    $pic_domain = "sit.admin.youaiyihu.com";
if($server_name=='dev.admin.youaiyihu.com')
    $pic_domain = "dev.admin.youaiyihu.com";
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'pic_domain' =>$pic_domain, //图片服务器
    'aliPay' => [
        'partner' => '2088911035311653',
        'seller_email' => 'pay@youaiyihu.com',
        'ali_public_key_path' => 'rsa_public_key.pem',
        'private_key_path' => 'rsa_public_key.pem',
        'sign_type' => 'RSA',
        'input_charset' => 'utf-8',
        'cacert' => 'alipay_cacert.pem',
        'transport' => 'http'
    ]
];