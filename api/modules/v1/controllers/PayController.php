<?php
/**
 * 充值接口
 * User: zhangbo
 * Date: 2015/4/11
 * Time: 17:38
 */

namespace api\modules\v1\controllers;

use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use backend\models\WalletUser;
class PayController extends ActiveController{
    public $modelClass = 'common\models\Order';
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
    public function actions(){
        return null;
    }

    public function actionCreate()
    {
        $post = Yii::$app->getRequest()->getBodyParams();
        if (empty($post['pay_way'])) {
            $this->responseCode = 400;
            $this->responseMsg = '支付方式为空';
            return false;
        }




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