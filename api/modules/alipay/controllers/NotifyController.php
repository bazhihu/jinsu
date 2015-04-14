<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/3
 * Time: 22:15
 */

namespace api\modules\alipay\controllers;

use Yii;
//use yii\log\Logger;
use yii\web\Response;
use yii\rest\ActiveController;


class NotifyController extends ActiveController{
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
    public function actionIndex(){
        echo 'index';
        exit;
    }

    /**
     * 登录
     * @return array|null
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate(){
        echo 'create';exit;
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