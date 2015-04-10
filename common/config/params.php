<?php
$server_name = $_SERVER['SERVER_NAME'] ; //图片服务器
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
    'pic_domain' =>$_SERVER['SERVER_NAME'] //图片服务器
];