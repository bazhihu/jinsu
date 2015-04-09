<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/3
 * Time: 0:31
 */

namespace api\modules\v1\controllers;

use common\models\Payment;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;
use backend\models\Worker;
use backend\models\WalletUser;
use common\models\Order;

class OrderController extends ActiveController {
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

    /**
     * 订单列表
     * @param $uid
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionIndex($uid){
        $query = Order::find()
            ->andFilterWhere(['uid' => $uid])
            ->orderBy(['order_id' => SORT_DESC])->all();

        $result = ArrayHelper::toArray($query);
        if(!empty($result)){
            foreach($result as $key => $item){
                $item['pic'] = Worker::workerPic($item['worker_no']);
                $result[$key] = $item;
            }
        }
        return $result;
    }

    /**
     * @return null|static
     */
    public function actionView(){
        $order_no = Yii::$app->request->get('id');
        $uid = Yii::$app->user->id;
        $query = Order::findOne(['order_no' => $order_no, 'uid' => $uid]);
        $result = ArrayHelper::toArray($query);

        if(!empty($result['worker_no'])){
            //获取护工照片
            $result['pic'] = Worker::workerPic($result['worker_no']);
        }
        return $result;
    }

    /**
     * 创建订单
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionCreate(){
        $post = Yii::$app->getRequest()->getBodyParams();
        if(empty($post['pay_way'])){
            $this->responseCode = 400;
            $this->responseMsg = '支付方式为空';
            return;
        }

        $params = ['OrderMaster' => $post];
        $params['OrderPatient']['patient_state'] = isset($post['patient_state']) ? $post['patient_state'] : null;

        $params['OrderMaster']['create_order_sources'] = Order::ORDER_SOURCES_MOBILE;

//        $orderModel = new Order();
//        $res = $orderModel->createOrder($params);
//        if(!$res){
//            $this->responseCode = 500;
//            $this->responseMsg = '创建订单失败';
//            return null;
//        }
//        $order = Order::findOne($orderModel->order_id);


        if($post['pay_way'] == Order::PAY_WAY_CASH){
            //$order->pay();
        }else{
            $payment = new Payment($post['pay_way']);
            exit;
        }


        //用户数据
        $user = [
            'mobile' => $order['mobile'],
            'uid' => $order['uid'],
            'wallet' => [
                'money' => WalletUser::getBalance($order['uid'])
            ]
        ];

        return [
            'order' => $order,
            'user' => $user
        ];
    }

    /**
     * 更新订单
     * @throws \yii\base\InvalidConfigException
     */
//    public function actionUpdate(){
//        $order_no = Yii::$app->request->get('id');
//        $post = Yii::$app->getRequest()->getBodyParams();
//        echo $order_no;exit;
//    }

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