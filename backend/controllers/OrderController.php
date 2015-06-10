<?php

namespace backend\controllers;

use backend\models\Recharge;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Order;
use backend\models\WalletUser;
use backend\models\OrderPatient;
use backend\models\OrderMaster;
use backend\models\OrderSearch;
use backend\models\User;
use common\models\Sms;
use backend\models\Worker;

/**
 * OrderController implements the CRUD actions for OrderMaster model.
 */
class OrderController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all OrderMaster models.
     * @return mixed
     */
    public function actionIndex(){
        //客服直接登录end
        $searchModel = new OrderSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single OrderMaster model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $orderPatientModel = OrderPatient::findOne(['order_id'=>$id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('view', [
                'model' => $model,
                'orderPatientModel' => $orderPatientModel]);
        }
    }

    /**
     * Creates a new OrderMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model = new OrderMaster;

        //从用户页面过来
        $uid = Yii::$app->request->get('uid');
        if(!empty($uid)){
            $user = User::findOne($uid);
            $model->mobile = $user->mobile;
            $model->contact_name = $user->name;
        }

        $orderPatientModel = new OrderPatient();
        if ($model->load(Yii::$app->request->post()) && $model->validate(['end_time'])) {
            $params = Yii::$app->request->post();

            //检查手机号是否注册
            $user = $model->checkMobile($params['OrderMaster']['mobile'], $params['OrderMaster']['contact_name']);

            $params['OrderMaster']['uid'] = $user->id;
            $params['OrderMaster']['patient_state'] = $params['OrderPatient']['patient_state'];
            $params['OrderMaster']['create_order_sources'] = OrderMaster::ORDER_SOURCES_SERVICE;
            $params['OrderMaster']['customer_service_id'] = \Yii::$app->user->id;

            $order = new Order();
            $order->createOrder($params);
            $order->pay();

            //发送短信
            if($order->order_status == OrderMaster::ORDER_STATUS_WAIT_PAY){
                $params['mobile'] = $order->mobile;
                $params['type'] = Sms::SMS_ORDERS_NOT_PAID;
                $params['time'] = $order->start_time;
                $params['level'] = Worker::$workerLevelLabel[$order->worker_level];
                Sms::send($params);
            }
            return $this->redirect(['view', 'id' => $order->order_id]);
        } else {
            //$model->addError('end_time', '结束时间不能小于或等于开始时间。');
            return $this->render('create', [
                'model' => $model,
                'orderPatientModel' => $orderPatientModel
            ]);
        }
    }

    /**
     * Updates an existing OrderMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);

        //检查订单状态
        if(!$model::checkOrderStatusAction($model->order_status, 'update')){
            return $this->redirect(['view', 'id' => $model->order_id]);
        }

        $orderPatientModel = OrderPatient::findOne(['order_id'=>$id]);
        $model->setScenario('update');
        if ($model->load(Yii::$app->request->post()) && $orderPatientModel->load(Yii::$app->request->post())) {
            $orderPatientModel->save();

            $model->reality_end_time = $model->end_time;
            $model->total_amount = $model->calculateTotalPrice();
            $model->patient_name = $orderPatientModel->name;

            $model->save();
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'orderPatientModel' => $orderPatientModel
            ]);
        }
    }

    /**
     * 续单
     * @param $id
     * @return string
     */
    public function actionContinue($id){
        $oldOrder = OrderMaster::findOne($id);
        $oldOrderPatient = OrderPatient::findOne(['order_id' => $id]);

        $model = new OrderMaster;
        $model->mobile = $oldOrder->mobile;
        $model->contact_name = $oldOrder->contact_name;
        $model->contact_telephone = $oldOrder->contact_telephone;
        $model->contact_address = $oldOrder->contact_address;
        $model->city_id = $oldOrder->city_id;
        $model->hospital_id = $oldOrder->hospital_id;
        $model->department_id = $oldOrder->department_id;
        $model->worker_no = $oldOrder->worker_no;
        $model->worker_name = $oldOrder->worker_name;
        $model->worker_level = $oldOrder->worker_level;
        $model->base_price = $oldOrder->base_price;
        $model->start_time = $oldOrder->reality_end_time;
        $model->remark = $oldOrder->remark;
        $model->is_continue = OrderMaster::IS_CONTINUE_YES;
        $model->order_type = $oldOrder->order_type;

        $orderPatientModel = new OrderPatient();
        if($oldOrderPatient){
            $orderPatientModel->name = $oldOrderPatient->name;
            $orderPatientModel->gender = $oldOrderPatient->gender;
            $orderPatientModel->age = $oldOrderPatient->age;
            $orderPatientModel->height = $oldOrderPatient->height;
            $orderPatientModel->weight = $oldOrderPatient->weight;
            $orderPatientModel->patient_state = $oldOrderPatient->patient_state;
            $orderPatientModel->in_hospital_reason = $oldOrderPatient->in_hospital_reason;
            $orderPatientModel->admission_date = empty($oldOrderPatient->admission_date) ? date('Y-m-d') : date('Y-m-d',strtotime($oldOrderPatient->admission_date));
            $orderPatientModel->room_no = $oldOrderPatient->room_no;
            $orderPatientModel->bed_no = $oldOrderPatient->bed_no;
        }

        return $this->render('create', [
            'model' => $model,
            'orderPatientModel' => $orderPatientModel
        ]);
    }

    /**
     * 订单支付
     * @param $id
     * @return array
     */
    public function actionPay($id){
        $order = $this->findModel($id);
        $response = $order->pay('后台订单支付');
        echo Json::encode($response);
    }

    /**
     * 订单确认
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionConfirm($id){
        $order = $this->findModel($id);
        $response = $order->confirm('后台选择护工下单');
        echo Json::encode($response);
    }
    /**
     * 开始服务
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionBegin_service($id){
        $order = $this->findModel($id);
        $response = $order->beginService();
        echo Json::encode($response);
    }

    /**
     * 订单完成
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionFinish($id){
        $this->layout = "guest.php";
        $params = Yii::$app->getRequest()->getBodyParams();
        $order = $this->findModel($id);
        if(empty($params['reality_end_time'])){
            return $this->render('finish', [
                'model' => $order
            ]);
        }else{
            $endTime = $params['reality_end_time'];
            $response = $order->finish($endTime);
            echo Json::encode($response);
        }
    }

    /**
     * 订单取消
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCancel($id){
        $this->layout = "guest.php";
        $reason = Yii::$app->getRequest()->getBodyParam('reason');
        $order = $this->findModel($id);
        if($reason){
            $orderStatus = $order->order_status;
            $response = $order->cancel($reason);
        }else{
            return $this->render('cancel', [
                'model' => $order
            ]);
        }

        //发送短信
        $isTrue = in_array($orderStatus, [Order::ORDER_STATUS_WAIT_CONFIRM,Order::ORDER_STATUS_WAIT_SERVICE]);
        if($response['code'] == 200 && $isTrue){
            $params['mobile'] = $order->mobile;
            $params['type'] = Sms::SMS_ORDER_CANCELED;
            $params['time'] = $order->start_time;
            $params['level'] = Worker::$workerLevelLabel[$order->worker_level];
            Sms::send($params);
        }
        echo Json::encode($response);
    }

    /**
     * Finds the OrderMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return OrderMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 订单价格计算
     * @return string
     */
    public function actionCalculate(){
        $this->layout = "none.php";
        $post = Yii::$app->request->post();
        $orderMaster = new OrderMaster();
        $orderMaster->scenario = 'calculate';
        if ($post) {
            $orderMaster->setAttributes($post);
            $orderMaster->reality_end_time = $orderMaster->end_time;

            //能否自理价格系数
            $patientState = $orderMaster->patient_state;
            $orderMaster->patient_state_coefficient = OrderPatient::$patientStatePrice[$patientState];

            return $this->render('calculate', [
                'model' => $orderMaster
            ]);
        }
    }

    /**
     * 充值
     * @throws NotFoundHttpException
     */
    public function actionRecharge(){
        $this->layout = "none.php";
        $orderId = Yii::$app->request->get('id');
        $orderModel = $this->findModel($orderId);
        $rechargeModel = new Recharge();
        if(Yii::$app->request->isPost){
            $post = ['Recharge' => Yii::$app->request->post()];
            if ($rechargeModel->load($post, 'Recharge') && $rechargeModel->validate()) {
                //支付渠道-后台
                $params = $post['Recharge'];
                $balance = \common\models\Wallet::recharge($params);

                //订单支付
                $response = $orderModel->pay('后台订单支付');

                //发送短信
                $sms = new Sms();
                $send = [
                    'mobile' => $orderModel->mobile,
                    'type' => Sms::SMS_SUCCESS_RECHARGE,
                    'account' => $orderModel->mobile,
                    'money' => $params['money'],
                    'balance' => $balance,
                ];
                $sms->send($send);

                $response = [
                    'code' => 200,
                    'msg' => '充值成功'.','.$response['msg']
                ];

                echo json_encode($response);
                return;
            }
        }

        $uid = $orderModel->uid;
        $rechargeModel->uid = $uid;

        //获得用户余额
        $wallet = WalletUser::findOne($uid);
        $balance = empty($wallet) ? 0 : $wallet->money;

        return $this->render('recharge', [
            'model' => $rechargeModel,
            'order' => $orderModel,
            'balance' => $balance
        ]);
    }

    /**
     * 订单统计
     * @return string
     */
    public function actionChart(){
        $orderSearch = new OrderSearch();
        $dataProvider = $orderSearch->chart(Yii::$app->request->getQueryParams());

        return $this->render('chart', [
            'dataProvider' => $dataProvider,
            'model' => $orderSearch
        ]);
    }
}
