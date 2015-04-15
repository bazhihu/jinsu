<?php
/**
 * 第三方支付
 * User: zhangbo
 * Date: 2015/4/9
 * Time: 20:31
 */

namespace common\models;

use yii\base\InvalidParamException;
use common\components\Alipay;


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
    public function generateTradeNo()
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

    private function _aliPay(){
        //生成交易号
        $transactionNo = $this->generateTradeNo();

        //支付日志
        $aliPayLog = new AlipayLog();
        $aliPayLog->setAttributes($this->_payData);
    }

    private function _WeChat(){

    }

    

}
