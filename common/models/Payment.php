<?php
/**
 * 第三方支付
 * User: zhangbo
 * Date: 2015/4/9
 * Time: 20:31
 */

namespace common\models;

use yii\base\InvalidParamException;
use common\models\Wallet;
use common\components\Alipay;
use common\components\Wechat;


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
                $this->_model = new Wechat();
                break;
        }
    }
    private function _aliPay(){

    }

    private function _WeChat(){

    }

    /**
     * 生成交易号
     */
    public function generateTradeNo()
    {
        $this->_tradeNo = Wallet::generateWalletNo();
    }

    public function payLog(){

    }
}
