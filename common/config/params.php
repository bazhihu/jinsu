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
    ]
];