<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/9
 * Time: 20:31
 */

namespace common\models;

use yii\base\InvalidParamException;

class Payment {
    public function __construct($payWay, $data){
        switch($payWay){
            case Order::PAY_WAY_ALIPAY:
                $this->_aliPay($data);
                break;
            case Order::PAY_WAY_WE_CHAT:
                $this->_weChat($data);
                break;
            default:
                throw new InvalidParamException("Pay way not found: $payWay");
        }
    }



    private static function _aliPay($data){
        echo 'alipay';
    }

    private static function _weChat($data){
        echo 'wechat';
    }
}