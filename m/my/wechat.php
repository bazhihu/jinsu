<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
@define("WEB_ROOT", "/www/youaiyihu.com");
require_once WEB_ROOT."/common/components/wxpay/lib/WxPay.Api.php";
require_once WEB_ROOT."/common/components/wxpay/unit/WxPay.JsApiPay.php";
require_once WEB_ROOT."/common/components/wxpay/unit/log.php";

#区分测试和线上回调路径
$notifyUrl = '';
$totalAmount=$_REQUEST["totalAmount"];
$needPay=$_REQUEST["totalAmount"]-$_REQUEST["walletMoney"];
if($_SERVER["HTTP_HOST"] !="m.youaiyihu.com"){
    $notifyUrl = 'http://uat.m.youaiyihu.com/my/notify.php';
    $needPays = 1;
}else{
    $needPays = $needPay*100;
    $notifyUrl = 'http://m.youaiyihu.com/my/notify.php';
}

//获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("优爱医护订单");
//$input->SetAttach('');//WxPayConfig::MCHID.date("YmdHis")
$input->SetOut_trade_no($_REQUEST["orderNo"]);
//$input->SetOut_trade_no($_REQUEST["orderNo"]);
//$input->SetTotal_fee($totalAmount);
$input->SetTotal_fee($needPays);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url($notifyUrl);
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);

$jsApiParameters = $tools->GetJsApiParameters($order);
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
    <input type="hidden" id="orderId" value="<?=$_REQUEST["orderNo"]?>"/>
    <section class="menu" role="menu">
            <span class="menuitem" role="menuitem">
                <em class="title">订单总金额：</em>
                <i class="value" id="total"><?=$_REQUEST["totalAmount"]?></i>
            </span>
    </section>

    <section class="menu" role="menu">
			<span class="menuitem" role="menuitem">
				<em class="title">钱包余额：</em>
				<i class="value" id="balance"><?=$_REQUEST["walletMoney"]?></i>
			</span>
    </section>

    <section class="payments menu" role="menu">
        <header class="menu-header">
            <span class="more">还需支付：<em id="needPay"><?=$needPay?></em>元</span>
            <input type="hidden" name="needPay" id="payMoney">
            <h3 class="menu-title">微信支付</h3>
        </header>
    </section>
<div id="foot"></div>
<script type="text/javascript" src="../js/zepto-with-touch.min.js"></script>
<script type="text/javascript" src="../js/public.js"></script>
<script>
    loggedIn();
    //调用微信JS api 支付
    function jsApiCall()
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            <?php echo $jsApiParameters; ?>,
            function(res){
                //WeixinJSBridge.log(res.err_msg);
                //alert(res.err_code+'#'+res.err_desc+'#'+res.err_msg);
                if(res.err_msg=="get_brand_wcpay_request:ok"){
                    window.location.href="../payOnline.html";
                }else{
                    location.href = host+'/my/orderDetail.html?order_no='+$('#orderId').val();
                    //history.back(-1);
                }
            });
    }
    function callwxpay()
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }
    callwxpay();
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
</script>
</body>
</html>