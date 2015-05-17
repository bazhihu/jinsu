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
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];Yii::info('wechat:'.$_POST, 'api');Yii::info('wechat:'.$xml, 'api');
        $notify->notifyUrl();
    }
    public function actionIndex(){
        return 'OK';
    }
}