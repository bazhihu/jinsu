<?php
/**
 * Created by PhpStorm.
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
    private $_model = null;

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
                $this->_model = new Alipay();
                break;
            case Order::PAY_WAY_WE_CHAT:
                $this->_model = new Wechat();
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
}
