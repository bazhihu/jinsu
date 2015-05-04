<?php
/**
 * 微信回调接口
 * User: zhangbo
 * Date: 2015/4/3
 * Time: 22:15
 */

namespace api\modules\wechat\controllers;

use api\modules\wechat\models\Notify;
use common\models\WechatLog;
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
        $notify = new Notify();
        $notify->notifyUrl();
    }

    /**
     * 判断交易是否存在
     * @param array $post 交易号
     * @return string
     */
    private function _checkNotify($post){
        $wechatLog = WechatLog::findOne(['transaction_no' => $post['out_trade_no']]);
        if(empty($wechatLog)){
            Yii::info('未找到订单', 'api');
            return 'fail';
        }
        if($wechatLog->trade_state == 'TRADE_FINISHED' || $wechatLog->trade_status == 'TRADE_SUCCESS'){
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