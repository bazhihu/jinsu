<?php
/**
 * 微信回调接口
 * User: zhangbo
 * Date: 2015/4/3
 * Time: 22:15
 */

namespace api\modules\wechat\controllers;

use api\modules\wechat\models\Notify;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;

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
     * 回调方法
     * @return array|null
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate(){
        notifyUrl();
    }

    /**
     * 获取用户openId
     */
    public function actionIndex(){
        $notify = new Notify();
        $res = $notify->getCode();
        return $res;
    }

    /**
     * 统一下单接口
     */
    public function actionView($id){
        $notify = new Notify();
        $res = $notify->underSingle($id);
        return $res;
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