<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/3
 * Time: 22:15
 */

namespace api\modules\v1\controllers;


use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;

class LoginController extends ActiveController{
    public $modelClass = 'common\models\User';
    public $responseCode = 200;
    public $responseMsg = null;

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }
    public function actions(){
        $actions = parent::actions();
        unset($actions['create'], $actions['delete'], $actions['update'], $actions['index'], $actions['view']);

        return $actions;
    }

    public function actionIndex(){
        echo 'login';exit;
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