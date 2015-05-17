<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
@define("WEB_ROOT", "/www/youaiyihu.com/");
require_once WEB_ROOT."/common/components/wxpay/lib/WxPay.Api.php";
require_once WEB_ROOT."/common/components/wxpay/unit/WxPay.JsApiPay.php";
require_once WEB_ROOT."/common/components/wxpay/unit/log.php";

//初始化日志
//$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);

function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
//echo $_REQUEST["orderNo"];
//echo "<br>";
$totalAmount=$_REQUEST["totalAmount"]*100;
//统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("优爱医护订单");
$input->SetAttach($_REQUEST["orderNo"]);
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
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
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);
//echo $jsApiParameters;
//exit();
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
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
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
			}
		);
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
		$('.menuitemradio input[type="radio"]').on('click', function () {
			[].forEach.call(this.form.elements[this.name], function (radio) {
				$(radio).parent()[radio === this ? 'addClass' : 'removeClass']('menuitemradio-checked');
			}, this);
		});
        loggedIn();
        var order_no = getUrlQueryString('orderNo'),
            total_amount = getUrlQueryString('totalAmount'),
            user = getStatus(),
            wei = isWeiXn(),
            alipay = $('#alipay'),
            wechat = $('#wechat'),
            pay = $('#pay');
        if(user.id && user.name && user.token){
            getUsers(user.id, user.token, function(back){
                if(total_amount>back.wallet.money){
                    var needPay;
                    $('.payments').attr('style',null);
                    needPay = total_amount-back.wallet.money;
                    if(needPay){
                        document.getElementById('needPay').innerHTML = needPay;
                        document.getElementById('payMoney').value = needPay;
                    }
                }
                document.getElementById('total').innerHTML  = '&yen;'+total_amount;
                document.getElementById('balance').innerHTML    = '&yen;'+back.wallet.money;
            });
        }
        pay.on(CLICK, function(){
            var orderUrls = orderUrl+'/'+order_no+'?access-token='+user.token,
                payWay = $('input[name=payment]:checked').val(),
                openId = '';
            //alert(payWay);
            if(payWay == '3'){
                //alert("wxpay");
            	callwxpay();
                /*
              $.ajax({
                    type: 'PUT',
                    url: orderUrls,
                    data: {'action':'payment','pay_way':payWay,'openId':'oL94Rs7rmq5KCz7ljaYoOZhA6evk'},
                    dataType: 'json',
                    async:false,
                    cache:false,
                    crossDomain:true,
                    timeout:30000,
                    success: function(data){alert(data);console.log(data);
                        if(data.code ==200){
                            //self.location=document.referrer;
                        }
                    },
                    error: function(xhr, type){
                        alert('网络超时!')
                    }
                })
                */
               // window.open('/my/wechat.php?orderNo='+order_no+'&accessToken='+user.token);
               // return false;
            }else if(payWay == '2'){
                alert('暂时没有支付宝支付');
                return false;
            }else{
            	window.location.href="../payOffline.html";
                /*
                $.ajax({
                    type: 'PUT',
                    url: orderUrls,
                    data: {'action':'payment','pay_way':payWay},
                    dataType: 'json',
                    async:false,
                    cache:false,
                    crossDomain:true,
                    timeout:30000,
                    success: function(data){
                        if(data.code ==200){
                            self.location=document.referrer;
                        }
                    },
                    error: function(xhr, type){
                        alert('网络超时!')
                    }
                })
                */
            }
        });
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
