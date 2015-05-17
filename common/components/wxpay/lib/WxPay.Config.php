<?php
/**
* 	配置账号信息
*/

class WxPayConfig
{
	//=======【基本信息设置】=====================================
	//
	/**
	 * 
	 * 微信公众号信息配置
	 * APPID：绑定支付的APPID（必须配置）
	 * MCHID：商户号（必须配置）
	 * KEY：商户支付密钥，参考开户邮件设置（必须配置）
	 * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置）
	 * @var string
	 */
	const APPID = 'wx35492d0f3afac96b';
	const MCHID = '1234118402';
	const KEY = 'cc8c2d501d7c1609fa1b73cff17a6f90';
	const APPSECRET = 'a7dc36de9adcefd71b616fdd08a8ff37';
	
	//=======【证书路径设置】=====================================
	/**
	 * 
	 * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要）
	 * @var path
	 */
	const SSLCERT_PATH = '';
	const SSLKEY_PATH = '';
	//const SSLCERT_PATH = '/www/youaiyihu.com/m/my/wxpayapi/cert/apiclient_cert.pem';
	//const SSLKEY_PATH = '/www/youaiyihu.com/m/my/wxpayapi/cert/apiclient_key.pem';	
	
	//=======【curl代理设置】===================================
	/**
	 * 
	 * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
	 * 默认0.0.0.0和0，此时不开启代理（如有需要才设置）
	 * @var unknown_type
	 */
	const CURL_PROXY_HOST = "0.0.0.0";
	const CURL_PROXY_PORT = 0;
	
	//=======【上报信息配置】===================================
	/**
	 * 
	 * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
	 * @var int
	 */
	const REPORT_LEVENL = 1;
	
	const NOTIFY_URL="http://uat.m.youaiyihu.com/my/notify.php";
	//const NOTIFY_URL="http://uat.api.youaiyihu.com/wechat/notify";
}
