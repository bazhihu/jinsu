<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/3
 * Time: 0:31
 */

namespace api\modules\v1\controllers;

use common\components\alipay\Alipay;
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
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

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
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionIndex(){
        $uid = Yii::$app->user->id;
        $page = Yii::$app->request->get('page');
        if(empty($page)){
            $page = 0;
        }else{
            $page = $page-1;
        }
        $perPage = 10;

        $query = Order::find()
            ->andFilterWhere(['uid' => $uid])
            ->orderBy(['order_id' => SORT_DESC])
            ->offset($perPage*$page)
            ->limit($perPage)
            ->all();

        $totalCount = Order::find()->andFilterWhere(['uid' => $uid])->count();

        $result = ArrayHelper::toArray($query);
        if(!empty($result)){
            foreach($result as $key => $item){
                $item['pic'] = Worker::workerPic($item['worker_no']);
                $result[$key] = $item;
            }
        }
        $meta = [
            'totalCount' => $totalCount,
            'pageCount' => ceil($totalCount/$perPage),
            'currentPage' => $page+1,
            'perPage' => $perPage
        ];
        return ['items' => $result, '_meta' => $meta];
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
            return false;
        }

        $params = ['OrderMaster' => $post];
        $params['OrderPatient']['patient_state'] = isset($post['patient_state']) ? $post['patient_state'] : null;

        $params['OrderMaster']['create_order_sources'] = Order::ORDER_SOURCES_MOBILE;

        $orderModel = new Order();
        $res = $orderModel->createOrder($params);
        if(!$res){
            $this->responseCode = 500;
            $this->responseMsg = '创建订单失败';
            return null;
        }
        $order = Order::findOne($orderModel->order_id);

        //支付
        $payment = $this->_payment($order, $post['pay_way']);

        return [
            'order' => $order,
            'payment' => $payment
        ];
    }

    /**
     * 支付
     * @param array $order 订单数据
     * @param int $payWay 支付方式
     * @return array|null
     */
    private function _payment($order, $payWay){
        $payment = null;
        if($payWay == Order::PAY_WAY_CASH){
            $order->pay();
            return null;
        }

        $uid = $order['uid'];
        $balance = WalletUser::getBalance($uid);

        $amount = $order['total_amount'] - $balance;
        if($amount <= 0){
            $this->responseCode = 500;
            $this->responseMsg = '支付金额错误';
            return null;
        }

        //支付数据
        $payment = [
            'uid' => $uid,
            'order_no' => $order['order_no'],
            'subject' => '订单号：'.$order['order_no'].'的付款',
            'amount' => $amount
        ];
        $paymentModel = new Payment($payWay, $payment);
        $payment['transaction_no'] = $paymentModel->getTradeNo();
        $payment['notify_url'] = Alipay::$notifyUrl;
        unset($payment['uid'], $payment['order_no']);

        return $payment;
    }

    /**
     * 更新订单
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate(){
        $order_no = Yii::$app->request->get('id');
        $uid = Yii::$app->user->id;

        $orderModel = Order::findOne(['order_no' => $order_no, 'uid' => $uid]);
        if(empty($orderModel)){
            $this->responseCode = 404;
            $this->responseMsg = '找不到要取消的订单';
            return null;
        }
        $action = Yii::$app->getRequest()->getBodyParam('action');

        if($action == 'cancel'){
            //取消订单
            $response = $orderModel->cancel();
        }elseif($action == 'payment'){
            //支付
            $payWay = Yii::$app->getRequest()->getBodyParam('pay_way');
            $payment = $this->_payment($orderModel, $payWay);
        }else{
            $this->responseCode = 400;
            $this->responseMsg = '参数错误';
            return null;
        }
        $order = ArrayHelper::toArray($orderModel);
        if($response['code'] == 200){
            if(!empty($order['worker_no'])){
                //获取护工照片
                $order['pic'] = Worker::workerPic($order['worker_no']);
            }
        }

        $this->responseCode = $response['code'];
        $this->responseMsg = $response['msg'];
        return [
            'order' => $order,
            'payment' => $payment
        ];;
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