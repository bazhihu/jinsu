<?php

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'pic_domain' => 'img.youaiyihu.com', //图片服务器
    'aliPay' => [
        'partner' => '2088911035311653',
        'seller_email' => 'pay@youaiyihu.com',
        'ali_public_key_path' => 'alipay_public_key.pem',
        'private_key_path' => 'rsa_private_key.pem',
        'sign_type' => 'RSA',
        'input_charset' => 'utf-8',
        'cacert' => 'alipay_cacert.pem',
        'transport' => 'http'
    ],
    'wechat'=>[
        'appId'         =>  'wx35492d0f3afac96b',//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
        'appSecret'     =>  'a7dc36de9adcefd71b616fdd08a8ff37',//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
        'mchId'         =>  '1234118402',//受理商ID，身份标识
        'key'           =>  'cc8c2d501d7c1609fa1b73cff17a6f90',//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
        'transport'     =>  'http',
        'curl_timeout'  =>  30,
        'sslCert_path'  =>  './../certificate/apiclient_cert.pem',
        'sslKey_path'   =>  './../certificate/apiclient_key.pem',
        'seller_email'  =>  'pay@youaiyihu.com',
        'report_levenl' =>  1,
        'curl_proxy_host' =>  '0.0.0.0',
        'curl_proxy_port' =>  '0',
        'notify_url'    =>  'http://uat.api.youaiyihu.com/wechat/notify',
    ]
];