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

class Payment {
    private $_payWay = null;
    private $_payData = null;
    private $_tradeNo = null;

    public static $allowPayWay = [
        Order::PAY_WAY_ALIPAY,
        Order::PAY_WAY_WE_CHAT
    ];

    public function __construct($payWay, $data){

        $this->_payWay = $payWay;
        $this->_payWay = $data;
        if(!in_array($payWay, self::$allowPayWay)){
            throw new InvalidParamException("Pay way not found: $payWay");
        }
        switch($payWay){
            case Order::PAY_WAY_ALIPAY:
                $this->_aliPay($data);
                break;
            case Order::PAY_WAY_WE_CHAT:
                $this->_weChat($data);
                break;
        }
    }

    /**
     * 生成交易号
     */
    public function generateTradeNo(){
        $this->_tradeNo = Wallet::generateWalletNo();
    }


    private static function _aliPay($data){
        echo 'alipay';
    }

    private static function _weChat($data){
        echo 'wechat';
    }
}