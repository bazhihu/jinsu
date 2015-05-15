<?php
namespace common\components\wechat;

use backend\models\WalletUserDetail;
use common\models\Order;
use common\models\Wallet;
use common\models\WechatLog;
use Yii;
use yii\base\Exception;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/14
 * Time: 22:17
 */
class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }

        //判断该笔订单是否在商户网站中已经做过处理
        $result = $this->_checkNotify($data);
        if($result != 'ok'){
            echo $result;
            Yii::info('返回微信:'.$result, 'api');
            return false;
        }

        //给用户钱包加钱
        $params = [
            'uid' => $this->_logModel->uid,
            'pay_from' => WalletUserDetail::PAY_FROM_WECHAT,
            'money' => $data['total_fee']
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
                Yii::info('返回微信：fail', 'api');
                return false;
            }
        }
        return true;
    }
    /**
     * 判断交易是否存在
     * @param array $post 交易号
     * @return string
     */
    private function _checkNotify($post){

        $wechatLog = WechatLog::findOne(['transaction_no' => $post['out_trade_no']]);
        if(empty($wechatLog)){
            Yii::info('未找到交易记录:out_trade_no='.$post['out_trade_no'], 'api');
            return 'fail';
        }
        if($wechatLog->trade_state == 'TRADE_FINISHED' || $wechatLog->trade_state == 'TRADE_SUCCESS'){
            return 'success';
        }

        if($wechatLog->total_fee != $post['total_fee']){
            Yii::info('交易金额错误', 'api');
            return 'fail';
        }

        //保存支付日志
        $wechatLog->setAttributes($post);
        if(!$wechatLog->save()){
            Yii::info('支付日志保存失败:'.print_r($wechatLog->getErrors(), true), 'api');
        }
        $this->_logModel = $wechatLog;
        return 'ok';
    }
}