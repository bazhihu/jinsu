<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/30
 * Time: 15:28
 */
namespace common\components\wechat;
use yii;
use yii\base\Exception;

/**
 * 对账单接口
 */
class DownloadBillPub extends WxpayClientPub
{

    function __construct()
    {
        //设置接口链接
        $this->url = "https://api.mch.weixin.qq.com/pay/downloadbill";
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
            if($this->parameters["bill_date"] == null )
            {
                throw new Exception("对账单接口中，缺少必填参数bill_date！"."<br>");
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

    /**
     * 	作用：获取结果，默认不使用证书
     */
    function getResult()
    {
        $this->postXml();
        $this->result = $this->xmlToArray($this->result_xml);
        return $this->result;
    }



}