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
    'pic_domain' => $picDomain, //图片服务器
];
