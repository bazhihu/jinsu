<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/9
 * Time: 17:30
 */

namespace api\modules\wechat\models;

use backend\models\WalletUserDetail;
use common\models\Wallet;
use common\models\WechatLog;
use Yii;
use common\components\wechat;
use common\components\wechat\WxpayServerPub;

class Notify{

    function getCode(){

        $jsApi = new JsApi_pub();

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

    function notifyUrl(){
        //使用通用通知接口
        $notify = new WxpayServerPub();

        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);

        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;

        Yii::info("【接收到的notify通知】:\n".$xml."\n", 'wechat');

        if($notify->checkSign() == TRUE)
        {
            $wechat = WechatLog::findOne(['transaction_no'=>$notify->data['out_trade_no']]);
            
            if ($notify->data["return_code"] == "FAIL") {

                Yii::info("【通信出错】:\n".$xml."\n", 'wechat');
            }
            elseif($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                Yii::info("【业务出错】:\n".$xml."\n", 'wechat');
            }
            else{

                $order_no = $notify->data['out_trade_no'];
                //给用户钱包加钱
                $params = [
                    'uid' => $this->_logModel->uid,
                    'pay_from' => WalletUserDetail::PAY_FROM_ALIPAY,
                    'money' => $notify->data['total_Fee']
                ];
                Wallet::recharge($params);

                //调用订单支付接口方法
                $orderNo = $this->_logModel->order_no;
                if(!empty($orderNo)){

                    $orderModel = Order::findOne(['order_no' => $orderNo]);
                    $response = $orderModel->pay();
                    Yii::info('$response:'.print_r($response, true), 'api');

                    if($response != 200){
                        echo "fail";
                        Yii::info('返回支付宝：fail', 'wechat');
                        return false;
                    }
                }

                Yii::info("【支付成功】:\n".$xml."\n", 'wechat');
            }
        }
    }
}