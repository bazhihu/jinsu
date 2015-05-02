<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/4/30
 * Time: 15:35
 */
namespace common\components\wechat;

use Yii;
use yii\base\Exception;
/**
 * 短链接转换接口
 */
class ShortUrl_pub extends Wxpay_client_pub
{
    function __construct()
    {
        //设置接口链接
        $this->url = "https://api.mch.weixin.qq.com/tools/shorturl";
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
            if($this->parameters["long_url"] == null )
            {
                throw new Exception("短链接转换接口中，缺少必填参数long_url！"."<br>");
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
     * 获取prepay_id
     */
    function getShortUrl()
    {
        $this->postXml();
        $prepay_id = $this->result["short_url"];
        return $prepay_id;
    }

}