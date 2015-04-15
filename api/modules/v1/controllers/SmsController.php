<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/4
 * Time: 18:58
 */

namespace api\modules\v1\controllers;

use common\models\Sms;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;

class SmsController extends ActiveController{
    public $modelClass = false;
    public $responseCode = 200;
    public $responseMsg = null;

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }
    public function actions(){
        return null;
    }

    public function actionCreate(){
        $sms = new Sms();
        $sms->setAttributes(Yii::$app->getRequest()->getBodyParams());

        if(!$sms->validate()){
            $this->responseCode = 400;
            $this->responseMsg = $sms->getFirstError('mobile');
            return null;
        }

        $params['mobile'] = $sms->mobile;
        $params['type'] = Sms::SMS_LOGIN_CODE;
        $params['code'] = rand(100000, 999999);
        Yii::$app->cache->set($sms->mobile, $params['code'], 300);
        return $sms::send($params);
    }

    /**
     * 返回数据处理
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        $response = [
            'code' => $this->responseCode,
            'msg' => $this->responseMsg,
            'data' => null
        ];
        $result = parent::afterAction($action, $result);
        $response['data'] = $result;
        return $this->serializeData($response);
    }

}