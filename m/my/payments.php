<?php
$user_agent = $_SERVER['HTTP_USER_AGENT'];
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
        $openid = getOpenidFromMp($code);
        var_dump($openid);
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
    //运行curl，结果以jason形式返回
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
	<header id="header">
		<a class="back" href="javascript:history.back(1)">返回</a>
		<h2 class="title">支付方式</h2>
        <a class="home" href="/">首页</a>
	</header>
	<form class="menu-form">

        <section class="menu" role="menu">
            <span class="menuitem" role="menuitem">
                <em class="title">订单总金额：</em>
                <i class="value" id="total"></i>
            </span>
        </section>

        <section class="menu" role="menu">
			<span class="menuitem" role="menuitem">
				<em class="title">钱包余额：</em>
				<i class="value" id="balance"></i>
			</span>
		</section>

		<section class="payments menu" role="menu" style="display: none;">
			<header class="menu-header">
				<span class="more">还需支付：<em id="needPay">0</em>元</span>
                <input type="hidden" name="needPay" id="payMoney">
				<h3 class="menu-title">支付方式</h3>
			</header>
			<label class="menuitemradio-checked menuitem menuitemradio" for="pay-offline" role="menuitemradio">
				<span class="pay-offline"></span>
				<em>当面支付</em>
				<i>提交成功后，工作人员会联系您收取现金</i>
				<input type="radio" name="payment" checked="checked" id="pay-offline" value="1" />
			</label>
			<label class="menuitem menuitemradio" id="alipay" for="pay-alipay" role="menuitemradio">
				<span class="pay-alipay"></span>
				<em>支付宝支付</em>
				<i>推荐有支付宝账号的用户使用</i>
				<input type="radio" name="payment" id="pay-alipay" value="2" />
			</label>
			<label class="menuitem menuitemradio" id="wechat" for="pay-wechat" role="menuitemradio">
				<span class="pay-wechat"></span>
				<em>微信支付</em>
				<i>推荐安装微信5.0以上版本用户使用</i>
				<input type="radio" name="payment" id="pay-wechat" value="3" />
			</label>
		</section>

		<input type="button" id="pay" value="立即支付" />
	</form>
	<script src="../js/zepto-with-touch.min.js"></script>
	<script src="../js/public.js"></script>
	<script src="../js/my/payments.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
		$('.menuitemradio input[type="radio"]').on('click', function () {
			[].forEach.call(this.form.elements[this.name], function (radio) {
				$(radio).parent()[radio === this ? 'addClass' : 'removeClass']('menuitemradio-checked');
			}, this);
		});
	</script>
</body>
</html>
