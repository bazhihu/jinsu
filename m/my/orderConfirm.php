<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

if($_SERVER['HTTP_HOST']=='dev.m.youaiyihu.com'){
    define("WEB_ROOT", "D:/work/youaiyihu/");
}elseif($_SERVER['HTTP_HOST']=='sit.m.youaiyihu.com'){
    define("WEB_ROOT", "/www/youaiyihu.com/");
}if($_SERVER['HTTP_HOST']=='uat.m.youaiyihu.com'){
    define("WEB_ROOT", "/www/youaiyihu.com/");
}if($_SERVER['HTTP_HOST']=='m.youaiyihu.com'){
    define("WEB_ROOT", "/www/youaiyihu.com/");
}
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
//$totalAmount=$_REQUEST["totalAmount"]*100;
//统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("优爱医护订单");
$input->SetAttach("test");
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
<body id="page-confirm">
<header id="header">
    <a class="back" href="javascript:history.back(-1)">返回</a>
    <h2 class="title">确认订单</h2>
    <a class="home" href="/">首页</a>
</header>
<div id="body"></div>
<script id="bodyTemplate" type='text/html'>
    <form class="menu-form"  action="" method="post">
        <input type="hidden" value="{{uid}}" name="uid">
        <input type="hidden" value="{{mobile}}" name="mobile">
        <section class="menu">
            <h3 class="menu-title">订单内容</h3>
            <div class="menuitem" role="menuitem">
                <em class="title">服务时间：</em>
                <span class="detail">{{start_time}}至{{end_time}}</span>
                <input type="hidden"  name="start_time" value="{{start_time}}">
                <input type="hidden" name="end_time" value="{{end_time}}">
                <i class="value">共{{days}}天</i>
            </div>
            <div class="menuitem" role="menuitem">
                <em class="title">服务医院：</em>
                <i class="value">{{hospitals_name}}</i>
                <input type="hidden" name="hospital_id" value="{{hospital_id}}">
            </div>
            <div class="menuitem" role="menuitem">
                <em class="title">服务科室：</em>
                <i class="value">{{departments_name}}</i>
                <input type="hidden" name="department_id" value="{{department_id}}">
            </div>
            <!--<div class="menuitem" role="menuitem">-->
                <!--<em class="title">病患状态：</em>-->
                <!--<i class="value">{{patient_states_name}}</i>-->
                <!--<input type="hidden" name="patient_state" value="{{patient_state}}">-->
            <!--</div>-->
            {{if type=='select'}}
                <div class="nurses-selected menuitem" role="menuitem">
                    <em class="title">护理员：</em>
                    <div class="nurses-detail">
                        <div class="nurses-photo" style="background-image: url({{if pic}}{{pic}}{{else}}/images/default-avatar.jpg{{/if}})"></div>
                        {{if worker_level==1}}
                            <h5 class="care-level-middle nurses-title">{{worker_level_name}}</h5>
                        {{/if}}
                        {{if worker_level==2}}
                            <h5 class="care-level-hight nurses-title">{{worker_level_name}}</h5>
                        {{/if}}
                        {{if worker_level==3}}
                            <h5 class="care-level-special nurses-title">{{worker_level_name}}</h5>
                        {{/if}}
                        <input type="hidden" name="worker_level" id="worker_level" value="{{worker_level}}">
                        <dl>
                            <dt>姓名：</dt>
                            <dd>{{worker_name}}&nbsp;</dd>
                            <dt>工号：</dt>
                            <dd>{{worker_no}}&nbsp;</dd>
                        </dl>
                    </div>
                </div>
            {{else}}
                <div class="menuitem" role="menuitem">
                    <em class="title">护理员：</em>
                    {{if worker_level==1}}
                        <i class="value care-level-middle">{{worker_level_name}}</i>
                    {{/if}}
                    {{if worker_level==2}}
                        <i class="value care-level-hight">{{worker_level_name}}</i>
                    {{/if}}
                    {{if worker_level==3}}
                        <i class="value care-level-special">{{worker_level_name}}</i>
                    {{/if}}
                    <input type="hidden" name="worker_level" id="worker_level" value="{{worker_level}}">
                </div>
            {{/if}}
        </section>

        <section class="menu" role="menu">
            <h3 class="menu-title">订单金额</h3>
            <div class="menuitem" role="menuitem">
                <table class="menu-detail">
                    <tbody>
                    <tr>
                        <td>{{worker_level_name}}服务{{days}}天</td>
                        <td>&yen;{{price}}×{{days}}</td>
                    </tr>
                    {{if has_holidays}}
                        <tr>
                            <td>法定节日加收2倍服务费<br style="font-size: 10px">{{has_holidays}}</td>
                            <td>&yen;{{price}}×2×{{has_holidays_num}}</td>
                        </tr>
                    {{/if}}
                    <tr>
                        <td>保险（暂无）</td>
                        <td>+0</td>
                    </tr>
                    <!--{{if patient_state==2}}-->
                        <!--<tr>-->
                            <!--<td>病患不可自理</td>-->
                            <!--<td>+{{patient_state_coefficient}}%</td>-->
                        <!--</tr>-->
                    <!--{{/if}}-->
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>订单总金额</td>
                        <td>&yen;{{true_pay}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <a href="/my/myWallet.html" class="menuitem" role="menuitem">
                <em class="title">钱包余额：</em>
                <i class="value">&yen;{{blance}}</i>
            </a>
        </section>
            {{if need_pay>0}}
                <header class="menu-header">
                    <span class="more">还需支付：<em>{{need_pay}}</em>元</span>
                    <h3 class="menu-title">支付方式</h3>
                </header>
                <div  id="pay_other">
                    <section class="payments menu" role="menu">
                        <label class="menuitemradio-checked menuitem menuitemradio" for="pay_offline" role="menuitemradio">
                            <span class="pay-offline"></span>
                            <em>当面支付</em>
                            <i>工作人员会联系您收取现金</i>
                            <input type="radio" name="pay_way"  checked id="pay_offline" value="1" />
                        </label>
                        <!--<label class="menuitem menuitemradio" for="pay_alipay" role="menuitemradio">-->
                        <!--<span class="pay-alipay"></span>-->
                        <!--<em>支付宝支付</em>-->
                        <!--<i>推荐有支付宝账号的用户使用</i>-->
                        <!--<input type="radio" name="pay_way"  id="pay_alipay" value="2" />-->
                        <!--</label>-->
                        <label class="menuitem menuitemradio" for="pay_wechat" role="menuitemradio">
                        <span class="pay-wechat"></span>
                        <em>微信支付</em>
                        <i>推荐安装微信5.0及以上版本的使用</i>
                        <input type="radio" name="pay_way"  id="pay_wechat" value="3" />
                        </label>
                    </section>
                </div>
            {{/if}}
            <input type="hidden" name="need_pay" id="need_pay" value="{{need_pay}}">
            <input type="button" value="确认支付" name="pay" id="pay"/>
        </form>
        </script>
    <div id="foot"></div>
    <script type="text/javascript">    
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
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
	</script>	        
<script type='text/javascript' src='../../js/template.js'></script>
<script type='text/javascript' src='../../js/zepto.min.js'></script>
<script type='text/javascript' src='../../js/zepto-with-touch.min.js'></script>
<script type='text/javascript' src='../../js/public.js?v=v1'></script>
<script type='text/javascript' src='../../js/order/orderConfirm.js?v=v1'></script>
</body>
</html>