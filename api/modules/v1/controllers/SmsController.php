<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/4
 * Time: 18:58
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\web\Response;
use yii\rest\ActiveController;

class SmsController extends ActiveController{
    public $modelClass = 'common\models\Sms';
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
        echo 'sms';exit;
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