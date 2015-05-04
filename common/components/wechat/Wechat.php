<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/5/4
 * Time: 11:18
 */
namespace common\components\wechat;

use Yii;


class Wechat {

    private $_config = null;

    public function __construct(){
        $this->_config = Yii::$app->params['wechat'];
    }

    public static function getNotifyUrl(){
        return 'http://'.Yii::$app->getRequest()->serverName.'/wechat/notify';
    }

    public static function getCode(){
        $jsApi = new JsApiPub();

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code']))
        {
            //触发微信返回code码
            $url = $jsApi->createOauthUrlForCode('http://'.$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL']);
            Header("Location: $url");
            exit;
        }else
        {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
            return $openid;
        }
    }

    public static function underSingle($openid, $out_trade_no, $totalFee){
        $unifiedOrder = new UnifiedOrderPub();

        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $unifiedOrder->setParameter("openid","$openid");//商品描述
        $unifiedOrder->setParameter("body","商品描述");//商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();
        $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号
        $unifiedOrder->setParameter("total_fee","$totalFee");//总金额
        $unifiedOrder->setParameter("notify_url",self::getNotifyUrl());//通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型

        $prepay_id = 1231231231231;//$unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi = new JsApiPub();
        $jsApi->setPrepayId($prepay_id);

        $jsApiParameters = $jsApi->getParameters();
        return $jsApiParameters;
    }
}