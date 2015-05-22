<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/15
 * Time: 0:31
 */

namespace api\modules\v2\controllers;

use common\models\Wallet;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;

class WalletController extends ActiveController {
    public $modelClass = 'common\models\Wallet';
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

        unset($actions['index'], $actions['view'], $actions['delete'], $actions['create'] ,$actions['update'] ,$actions['options']);

        return $actions;
    }

    /**
     * 获取用户钱包明细
     * @return array|mixed|null|static
     */
    public function actionView()
    {
        $id  = Yii::$app->request->get('id');
        if($id != \Yii::$app->user->id){
            throw new UnauthorizedHttpException('You are requesting with an invalid credential.');
        }
        $wallet = Wallet::getDetailsByUid($id);
        return $wallet;
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