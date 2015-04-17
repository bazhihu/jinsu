<?php
/**
 * 支付宝回调接口
 * User: zhangbo
 * Date: 2015/4/3
 * Time: 22:15
 */

namespace api\modules\alipay\controllers;

use common\models\Order;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use api\modules\alipay\models\Notify;
use common\models\AlipayLog;
use common\models\Wallet;

class NotifyController extends ActiveController{
    public $modelClass = false;
    public $responseCode = 200;
    public $responseMsg = null;

    private $_logModel = null;

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }
    public function actions(){
        return null;
    }

    /**
     * 支付宝回调方法
     * @return array|null
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate(){
        $post = Yii::$app->getRequest()->getBodyParams();
        Yii::info('======================回调开始：'.print_r($post, true), 'api');

        $notify = new Notify(Yii::$app->params['aliPay']);
        $verifyResult = $notify->verifyNotify($post);

        if($verifyResult) {//验证成功
            //交易号
            $transactionNo = $post['out_trade_no'];

            //交易状态
            $tradeStatus = $post['trade_status'];

            //交易金额
            $totalFee = $post['total_fee'];

            if($tradeStatus == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                $result = $this->_checkNotify($post);
                if($result != 'ok'){
                    echo $result;
                    return false;
                }

            }else if ($tradeStatus == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                $result = $this->_checkNotify($post);
                if($result != 'ok'){
                    echo $result;
                    return false;
                }

                //给用户钱包加钱
                Wallet::addMoney($this->_logModel->uid, $totalFee);

                //调用订单支付接口方法
                $orderNo = $this->_logModel->order_no;
                if(!empty($orderNo)){
                    $orderModel = Order::findOne(['order_no' => $orderNo]);
                    $response = $orderModel->pay();
                    Yii::info('$response:'.print_r($response, true), 'api');
                }
            }
            echo "success";
            Yii::info('回调结束：success', 'api');
        }else {
            //验证失败
            echo "fail";
            Yii::info('======================回调结束：fail', 'api');
        }
        exit();
    }

    /**
     * 判断交易是否存在
     * @param array $post 交易号
     * @return string
     */
    private function _checkNotify($post){
        $aliPayLog = AlipayLog::findOne(['transaction_no' => $post['out_trade_no']]);
        if(empty($aliPayLog)){
            Yii::info('未找到订单', 'api');
            return 'fail';
        }
        if($aliPayLog->trade_status == 'TRADE_FINISHED' || $aliPayLog->trade_status == 'TRADE_SUCCESS'){
            return 'success';
        }

        if($aliPayLog->total_fee != $post['total_fee']){
            Yii::info('交易金额错误', 'api');
            return 'fail';
        }

        //保存支付日志
        $aliPayLog->setAttributes($post);
        if(!$aliPayLog->save()){
            Yii::info('支付日志保存失败:'.print_r($aliPayLog->getErrors(), true), 'api');
        }
        $this->_logModel = $aliPayLog;
        return 'ok';
    }
}