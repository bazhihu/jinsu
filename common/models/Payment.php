<?php
/**
 * 第三方支付
 * User: zhangbo
 * Date: 2015/4/9
 * Time: 20:31
 */

namespace common\models;

use common\components\wechat\Wechat;
use Yii;
use yii\base\InvalidParamException;
use yii\web\HttpException;
use common\components\Alipay;


class Payment
{
    private $_payWay = null;
    private $_payData = null;
    private $_tradeNo = null;
    private $_weChatReturn = null;

    //允许支付方式
    public static $allowPayWay = [
        Order::PAY_WAY_ALIPAY,
        Order::PAY_WAY_WE_CHAT
    ];

    public function __construct($payWay, $data)
    {
        $this->_payWay = $payWay;
        $this->_payData = $data;
        if (!in_array($payWay, self::$allowPayWay)) {
            throw new InvalidParamException("Pay way not found: $payWay");
        }
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
    private function _generateTradeNo()
    {
        $this->_tradeNo = Wallet::generateWalletNo();
    }

    /**
     * 获取交易号
     * @return null
     */
    public function getTradeNo(){
        return $this->_tradeNo;
    }

    public function getReInformation(){
        $return = array();
        switch ($this->_payWay) {
            case Order::PAY_WAY_ALIPAY:
                $return = [
                    'notify_url'        => \common\components\alipay\Alipay::getNotifyUrl(),
                    'transaction_no'    => $this->_tradeNo,
                    'uid' => $this->_payData['uid'],
                    'subject' => '用户充值',
                    'amount' => $this->_payData['amount']
                ];
                break;
            case Order::PAY_WAY_WE_CHAT:
                $return = $this->_weChatReturn;
                break;
        }
        return $return;
    }

    /**
     * 支付宝
     * @return bool
     * @throws HttpException
     */
    private function _aliPay(){
        //生成交易号
        $this->_generateTradeNo();

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

        return true;
    }

    /**
     * 微信支付
     * @return bool
     * @throws HttpException
     */
    private function _WeChat(){
        $logData = $this->_payData;
        //生成交易号
        $this->_generateTradeNo();
        //统一下单
        $return = Wechat::underSingle($this->_payData['open_id'], $this->_tradeNo, $this->_payData['amount']);
        $this->_weChatReturn = $return;
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
