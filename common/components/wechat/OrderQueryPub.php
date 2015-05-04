<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/30
 * Time: 15:23
 */
namespace common\components\wechat;

use Yii;
use yii\base\Exception;

/**
 * 订单查询接口
 */
class OrderQueryPub extends WxpayClientPub
{
    function __construct()
    {
        //设置接口链接
        $this->url = "https://api.mch.weixin.qq.com/pay/orderquery";
        //设置curl超时时间
        $this->curl_timeout = Yii::$app->params['wechat']['curl_timeout'];
    }

    /**
     * 生成接口参数xml
     */
    function createXml()
    {
        try
        {
            //检测必填参数
            if($this->parameters["out_trade_no"] == null &&
                $this->parameters["transaction_id"] == null)
            {
                throw new Exception("订单查询接口中，out_trade_no、transaction_id至少填一个！"."<br>");
            }
            $this->parameters["appid"] = Yii::$app->params['wechat']['appId'];//公众账号ID
            $this->parameters["mch_id"] = Yii::$app->params['wechat']['mchId'];//商户号
            $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
            $this->parameters["sign"] = $this->getSign($this->parameters);//签名
            return  $this->arrayToXml($this->parameters);
        }catch (Exception $e)
        {
            die($e->getMessage());
        }
    }

}