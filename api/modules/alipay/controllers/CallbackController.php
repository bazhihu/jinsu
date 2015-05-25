<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/5/25
 * Time: 15:19
 */
namespace api\modules\alipay\controllers;

use api\modules\alipay\models\NotifyWap;
use common\models\Order;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use api\modules\alipay\models\Notify;
use common\models\AlipayLog;
use common\models\Wallet;
use backend\models\WalletUserDetail;

class CallbackController extends ActiveController{
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
    public function actionCreate()
    {

        $post = Yii::$app->getRequest()->getBodyParams();
        Yii::info('======================回调开始：' . print_r($post, true), 'api');

        $notify = new NotifyWap(Yii::$app->params['aliPayWap']);
        $verifyResult = $notify->verifyNotify($post);
        $verifyResult = true;
        if ($verifyResult) {//验证成功

            $doc = new \DOMDocument();
            if (Yii::$app->params['aliPayWap']['sign_type'] == 'MD5') {
                $doc->loadXML($_POST['notify_data']);
            }

            if (Yii::$app->params['aliPayWap']['sign_type'] == '0001') {
                $doc->loadXML($notify->decrypt($_POST['notify_data']));
            }

            if (!empty($doc->getElementsByTagName("notify")->item(0)->nodeValue)) {
                //商户订单号
                $out_trade_no = $doc->getElementsByTagName("out_trade_no")->item(0)->nodeValue;
                //支付宝交易号
                $trade_no = $doc->getElementsByTagName("trade_no")->item(0)->nodeValue;
                //交易状态
                $trade_status = $doc->getElementsByTagName("trade_status")->item(0)->nodeValue;

                $postDate = [
                    'out_trade_no' => $out_trade_no,
                    'trade_no' => $trade_no,
                    'trade_status' => $trade_status,
                    'total_fee' => $doc->getElementsByTagName("total_fee")->item(0)->nodeValue,
                    'seller_email' => $doc->getElementsByTagName("seller_email")->item(0)->nodeValue,
                    'buyer_email' => $doc->getElementsByTagName("buyer_email")->item(0)->nodeValue,
                    'gmt_create' => $doc->getElementsByTagName("gmt_create")->item(0)->nodeValue,
                    'notify_type' => $doc->getElementsByTagName("notify_type")->item(0)->nodeValue,
                    'notify_id' => $doc->getElementsByTagName("notify_id")->item(0)->nodeValue,
                    'seller_id' => $doc->getElementsByTagName("seller_id")->item(0)->nodeValue,
                    'buyer_id' => $doc->getElementsByTagName("buyer_id")->item(0)->nodeValue,
                    'gmt_payment' => $doc->getElementsByTagName("gmt_payment")->item(0)->nodeValue,
                ];
                if ($trade_status == 'TRADE_FINISHED') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    $result = $this->_checkNotify($postDate);
                    if ($result != 'ok') {
                        echo $result;
                        Yii::info('返回支付宝：' . $result, 'api');
                        return false;
                    }
                } else if ($trade_status == 'TRADE_SUCCESS') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    $result = $this->_checkNotify($postDate);
                    if ($result != 'ok') {
                        echo $result;
                        Yii::info('返回支付宝:' . $result, 'api');
                        return false;
                    }

                    //给用户钱包加钱
                    $params = [
                        'uid' => $this->_logModel->uid,
                        'pay_from' => WalletUserDetail::PAY_FROM_ALIPAY,
                        'money' => $postDate['total_fee'],
                    ];
                    Wallet::recharge($params);

                    //调用订单支付接口方法
                    $orderNo = $this->_logModel->order_no;
                    if (!empty($orderNo)) {
                        $orderModel = Order::findOne(['order_no' => $orderNo]);
                        $response = $orderModel->pay();
                        Yii::info('$response:' . print_r($response, true), 'api');

                        if ($response != 200) {
                            echo "fail";
                            Yii::info('返回支付宝：fail', 'api');
                            return false;
                        }
                    }
                }
                echo "success";
                Yii::info('======================回调结束：success', 'api');
            }
        }
    }

    /**
     * 判断交易是否存在
     * @param array $post 交易号
     * @return string
     */
    private function _checkNotify($post){
        $aliPayLog = AlipayLog::findOne(['transaction_no' => $post['out_trade_no']]);
        if(empty($aliPayLog)){
            Yii::info('未找到交易记录:out_trade_no='.$post['out_trade_no'], 'api');
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