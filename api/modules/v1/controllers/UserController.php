<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/2
 * Time: 21:58
 */

namespace api\modules\v1\controllers;

use common\models\User;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use yii\web\UnauthorizedHttpException;

class UserController extends ActiveController{
    public $modelClass = 'common\models\User';
    public $responseCode = 200;
    public $responseMsg = null;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return ArrayHelper::merge($behaviors, [
            'authenticator' => [
                'class' => QueryParamAuth::className()
            ],
        ]);
    }
    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" actions
        unset($actions['delete'], $actions['index'], $actions['view']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        //$actions['index']['prepareDataProvider'] = [$this, 'index'];

        return $actions;
    }

    /**
     * 用户数据接口
     * @param $id 用户ID
     * @return null|\yii\web\IdentityInterface|static
     * @throws UnauthorizedHttpException
     */
    public function actionView($id){
        if($id != \Yii::$app->user->id){
            throw new UnauthorizedHttpException('You are requesting with an invalid credential.');
        }
        $userData = ArrayHelper::toArray(User::findIdentity($id));
        $userData['uid'] = $userData['id'];
        unset($userData['id'],$userData['access_token'],$userData['password']);
        return $userData;
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