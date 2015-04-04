<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/3
 * Time: 22:15
 */

namespace api\modules\v1\controllers;

use common\models\Login;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use backend\models\WalletUser;

class LoginController extends ActiveController{
    public $modelClass = 'api\modules\v1\models\Login';
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

    /**
     * 登录
     * @return array|null
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate(){
        $loginModel = new Login();
        $loginModel->setAttributes(Yii::$app->getRequest()->getBodyParams());
        if(!$loginModel->validate()){
            $this->responseCode = 400;
            $this->responseMsg = $loginModel->getFirstError('authCode');
            return null;
        }

        $user = $loginModel->getUser();
        $result = [
            'uid' => $user->id,
            'mobile' => $user->mobile,
            'wallet' => [
                'money' => WalletUser::getBalance($user->id)
            ]
        ];
        return $result;
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