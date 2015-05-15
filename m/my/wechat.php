<?php
error_reporting(0);
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$openId = '';
if (strpos($user_agent, 'MicroMessenger') || strpos($user_agent, 'micromessenger')) {
    define('APPID','wx35492d0f3afac96b');
    define('APPSECRET','a7dc36de9adcefd71b616fdd08a8ff37');
    //通过code获得openid
    if (!isset($_GET['code'])){
        //触发微信返回code码
        $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        $url = CreateOauthUrlForCode($baseUrl);
        Header("Location: $url");
        exit();
    } else {
        //获取code码，以获取openid
        $code = $_GET['code'];
        $openId = getOpenidFromMp($code);
    }
}
function CreateOauthUrlForCode($redirectUrl)
{
    $urlObj["appid"] = APPID;
    $urlObj["redirect_uri"] = "$redirectUrl";
    $urlObj["response_type"] = "code";
    $urlObj["scope"] = "snsapi_base";
    $urlObj["state"] = "STATE"."#wechat_redirect";
    $bizString = ToUrlParams($urlObj);
    return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
}
function ToUrlParams($urlObj)
{
    $buff = "";
    foreach ($urlObj as $k => $v)
    {
        if($k != "sign"){
            $buff .= $k . "=" . $v . "&";
        }
    }

    $buff = trim($buff, "&");
    return $buff;
}
function GetOpenidFromMp($code)
{
    $url = CreateOauthUrlForOpenid($code);
    //初始化curl
    $ch = curl_init();
    //设置超时
    curl_setopt($ch, CURLOPT_TIMEOUT,30);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    /*if(Yii::$app->params['wechat']['curl_proxy_host'] != "0.0.0.0"
        && Yii::$app->params['wechat']['curl_proxy_port'] != 0){
        curl_setopt($ch,CURLOPT_PROXY, Yii::$app->params['wechat']['curl_proxy_host']);
        curl_setopt($ch,CURLOPT_PROXYPORT, Yii::$app->params['wechat']['curl_proxy_port']);
    }*/
    //运行curl，结果以json形式返回
    $res = curl_exec($ch);
    curl_close($ch);
    //取出openid
    $data = json_decode($res,true);
    $openid = $data['openid'];
    return $openid;
}
function CreateOauthUrlForOpenid($code)
{
    $urlObj["appid"] = APPID;
    $urlObj["secret"] = APPSECRET;
    $urlObj["code"] = $code;
    $urlObj["grant_type"] = "authorization_code";
    $bizString = ToUrlParams($urlObj);
    return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>优爱医护</title>
    <meta name="viewport" content="width=320,user-scalable=no" />
    <meta content="telephone=no" name="format-detection" />
    <link href="../css/style.css" rel="stylesheet" />
</head>
<body id="page-payments">
<input type="hidden" id="openId" value="<?=$openId?>">
<script src="../js/zepto-with-touch.min.js"></script>
<script src="../js/public.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    $(loggedIn();
        var order_no = getUrlQueryString('orderNo'),
            total_amount = getUrlQueryString('totalAmount'),
            user = getStatus(),
            wei = isWeiXn();

        var orderUrls = orderUrl+'/'+order_no+'?access-token='+user.token,
            openId = $('#openId').val();

        ready(function($){
            if(openId){
                $.ajax({
                    type: 'PUT',
                    url: orderUrls,
                    data: {'action':'payment','pay_way':'3','openId':openId},
                    dataType: 'json',
                    async:false,
                    cache:false,
                    crossDomain:true,
                    timeout:30000,
                    success: function(back){
                        if(back.code ==200){
                            callpay(back.data['payment']);
                        }
                    },
                    error: function(xhr, type){
                        alert('网络超时!')
                    }
                });
            }
        });
        function jsApiCall(jsApiParameters)
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                jsApiParameters,
                function(res){
                    if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                        self.location = '/payOnline.html';
                    }else{
                        //支付失败
                    }
                }
            );
        }
        function callpay(jsApiParameters)
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall(jsApiParameters);
            }
        }
        if(wei)
            alipay.attr('style','display:none');
        else
            wechat.attr('style','display:none');
        function isWeiXn(){
            var ua = navigator.userAgent.toLowerCase();
            if(ua.match(/MicroMessenger/i)=="micromessenger")
                return true;
            else
                return false;
        }
    )
</script>
</body>
</html>