<?php
/**
 * 充值接口
 * User: zhangbo
 * Date: 2015/4/11
 * Time: 17:38
 */

namespace api\modules\v1\controllers;

use api\modules\v1\models\Pay;
use common\models\Order;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use common\models\Payment;
use common\components\alipay\Alipay;

class PayController extends ActiveController{
    public $modelClass = 'api\modules\v1\models\Pay';
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

    public function actionCreate(){
        $post = Yii::$app->getRequest()->getBodyParams();
        $payModel = new Pay();
        //场景判断
        if(isset($post['pay_way']) && $post['pay_way'] == Order::PAY_WAY_ALIPAY){
            $payModel->setScenario('alipay');
        }else{
            $payModel->setScenario('wechat');
        }
        $payModel->setAttributes($post);
        if(!$payModel->validate()){
            $this->responseCode = 400;
            $this->responseMsg = print_r($payModel->getErrors(), true);
            return null;
        }

        //支付数据
        $payment = [
            'uid' => $post['uid'],
            'subject' => '用户充值',
            'amount' => $post['amount']
        ];

        if(isset($post['openId'])){
            $payment['open_id'] = $post['openId'];
        }
        $paymentModel = new Payment($post['pay_way'], $payment);

        $return = $paymentModel->getReInformation();
        return $return;
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