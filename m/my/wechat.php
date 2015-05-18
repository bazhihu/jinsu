<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
@define("WEB_ROOT", "/www/youaiyihu.com");
require_once WEB_ROOT."/common/components/wxpay/lib/WxPay.Api.php";
require_once WEB_ROOT."/common/components/wxpay/unit/WxPay.JsApiPay.php";
require_once WEB_ROOT."/common/components/wxpay/unit/log.php";

function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}
//获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

$totalAmount=$_REQUEST["totalAmount"]*100;
//统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("优爱医护订单");
//$input->SetAttach('');//WxPayConfig::MCHID.date("YmdHis")
$input->SetOut_trade_no($_REQUEST["orderNo"]);
//$input->SetOut_trade_no($_REQUEST["orderNo"]);
//$input->SetTotal_fee($totalAmount);
$input->SetTotal_fee(1);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://uat.m.youaiyihu.com/my/notify.php");
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
<input type="hidden" id="openId" value="<?=$openId?>">
<script src="../js/zepto-with-touch.min.js"></script>
<script src="../js/public.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    loggedIn();
    callwxpay();
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