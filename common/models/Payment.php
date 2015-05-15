<?php
/**
 * 第三方支付
 * User: zhangbo
 * Date: 2015/4/9
 * Time: 20:31
 */

namespace common\models;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\web\HttpException;
use common\components\alipay\Alipay;
use common\components\wechat\JsApiPay;
use common\components\wechat\WxPayUnifiedOrder;
use common\components\wechat\WxPayApi;

class Payment
{
    private $_payWay = null;
    private $_payData = null;
    private $_tradeNo = null;

    //允许支付方式
    public static $allowPayWay = [
        Order::PAY_WAY_ALIPAY,
        Order::PAY_WAY_WE_CHAT
    ];

    public function __construct($payWay, $data){
        $this->_payWay = $payWay;
        $this->_payData = $data;
        if (!in_array($payWay, self::$allowPayWay)) {
            throw new InvalidParamException("Pay way not found: $payWay");
        }

        //生成交易号
        $this->_generateTradeNo();

        switch ($payWay) {
            case Order::PAY_WAY_ALIPAY:
                $this->_aliPay();
                break;
            case Order::PAY_WAY_WE_CHAT:
                $this->_WeChat();
                break;
        }
    }

    /**
     * 生成交易号
     */
    private function _generateTradeNo(){
        $this->_tradeNo = Wallet::generateWalletNo();
    }

    /**
     * 获取交易号
     * @return null
     */
    public function getTradeNo(){
        return $this->_tradeNo;
    }

    /**
     * 获取支付数据
     * @return null
     */
    public function getPayData(){
        Yii::info('支付数据：'.print_r($this->_payData, true), 'api');
        return $this->_payData;
    }

    /**
     * 支付宝
     * @return bool
     * @throws HttpException
     */
    private function _aliPay(){
        //支付日志
        $aliPayLog = new AlipayLog();
        $logData = $this->_payData;
        $logData['transaction_no'] = $this->_tradeNo;
        $logData['total_fee'] = $this->_payData['amount'];
        $aliPayLog->setAttributes($logData);
        if(!$aliPayLog->save()){
            Yii::info(print_r($aliPayLog->getErrors(), true), 'api');
            throw new HttpException(400, print_r($aliPayLog->getErrors(), true));
        }

        $this->_payData['transaction_no'] = $this->_tradeNo;
        $this->_payData['notify_url'] = Alipay::getNotifyUrl();
        unset($this->_payData['uid'], $this->_payData['order_no']);

        return true;
    }

    /**
     * 微信支付
     * @return bool
     * @throws HttpException
     */
    private function _WeChat(){
        //统一下单
        $jsApi = new JsApiPay();
        $Wechat = new WxPayUnifiedOrder();
        $Wechat->SetBody("优爱医护护工服务！");
        $Wechat->SetAttach("优爱医护护工服务！");
        $Wechat->SetOut_trade_no($this->_tradeNo);
        $Wechat->SetTotal_fee($this->_payData['amount']);
        $Wechat->SetTime_start(date("YmdHis"));
        $Wechat->SetTime_expire(date("YmdHis", time() + 600));
        $Wechat->SetGoods_tag("优爱医护护工服务！");
        $Wechat->SetNotify_url(Yii::$app->params['wechat']['notify_url']);
        $Wechat->SetTrade_type("JSAPI");
        $Wechat->SetOpenid($this->_payData['openId']);
        $order = WxPayApi::unifiedOrder($Wechat);
        $jsApiParameters = $jsApi->GetJsApiParameters($order);

        //支付日志
        $logData = $this->_payData;

        $logData['transaction_no'] = $this->_tradeNo;
        $logData['total_fee'] = $this->_payData['amount'];
        $logData['body'] = $this->_payData['subject'];
        $logData['partner'] = Yii::$app->params['wechat']['mchId'];
        $logData['gmt_create'] = date('Y-m-d H:i:s');
        $logData['spbill_create_ip'] = Yii::$app->request->userIP;

        $wechatLog = new WechatLog();
        $wechatLog->setAttributes($logData);

        if(!$wechatLog->save()){
            Yii::info(print_r($wechatLog->getErrors(), true), 'api');
            throw new HttpException(400, print_r($wechatLog->getErrors(), true));
        }

        return true;
    }
}
