<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/3/21
 * Time: 18:25
 */
namespace common\models;

use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use backend\models\Holidays;
use backend\models\OrderIncrement;
use backend\models\OrderOperatorLog;
use backend\models\OrderPatient;
use backend\models\Worker;
use backend\models\WorkerSchedule;
use backend\models\WalletUserDetail;

class Order extends \yii\db\ActiveRecord{
    //订单来源
    const ORDER_SOURCES_WEB = 'web'; //web网站
    const ORDER_SOURCES_MOBILE = 'mobile'; //移动客户端
    const ORDER_SOURCES_SERVICE = 'service'; //客服

    static $orderSources = [
        self::ORDER_SOURCES_WEB => '网站',
        self::ORDER_SOURCES_MOBILE => '移动客户端',
        self::ORDER_SOURCES_SERVICE => '客服电话',
    ];

    //订单状态
    const ORDER_STATUS_WAIT_PAY = 'wait_pay'; //待支付
    const ORDER_STATUS_WAIT_CONFIRM = 'wait_confirm'; //待确认
    const ORDER_STATUS_WAIT_SERVICE = 'wait_service'; //待服务
    const ORDER_STATUS_IN_SERVICE = 'in_service'; //服务中
    const ORDER_STATUS_END_SERVICE = 'end_service'; //结束服务
    const ORDER_STATUS_CANCEL = 'cancel'; //取消订单
    const ORDER_STATUS_WAIT_EVALUATE = 'wait_evaluate'; //待评价

    static public $orderStatusLabels = [
        self::ORDER_STATUS_WAIT_PAY => '待支付',
        self::ORDER_STATUS_WAIT_CONFIRM => '待确认',
        self::ORDER_STATUS_WAIT_SERVICE => '待服务',
        self::ORDER_STATUS_IN_SERVICE => '服务中',
        self::ORDER_STATUS_END_SERVICE => '结束服务',
        self::ORDER_STATUS_CANCEL => '取消订单',
        self::ORDER_STATUS_WAIT_EVALUATE => '待评价'
    ];

    //节假日价格倍数
    const HOLIDAY_PRICE_MULTIPLIER = 3;

    //订单状态动作配置
    static public $orderStatusActions = [
        //支付
        'pay' => [
            self::ORDER_STATUS_WAIT_PAY
        ],
        //更新
        'update' => [
            //self::ORDER_STATUS_WAIT_CONFIRM,
            //self::ORDER_STATUS_WAIT_SERVICE,
            //self::ORDER_STATUS_IN_SERVICE
        ],
        //确认
        'confirm' => [
            self::ORDER_STATUS_WAIT_CONFIRM
        ],
        //开始服务
        'begin_service' => [
            self::ORDER_STATUS_WAIT_SERVICE
        ],
        //完成
        'finish' => [
            self::ORDER_STATUS_IN_SERVICE
        ],
        //续单
        'continue' => [
            self::ORDER_STATUS_IN_SERVICE
        ],
        //取消
        'cancel' => [
            self::ORDER_STATUS_WAIT_PAY,
            self::ORDER_STATUS_WAIT_SERVICE,
            self::ORDER_STATUS_WAIT_CONFIRM
        ],
        //评价
        'evaluate' => [
            self::ORDER_STATUS_WAIT_EVALUATE
        ]
    ];

    public $orderCycle; //订单周期

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_no', 'worker_level', 'mobile', 'hospital_id', 'department_id', 'base_price', 'patient_state', 'start_time', 'end_time', 'reality_end_time', 'create_time', 'create_order_ip', 'create_order_sources', 'create_order_user_agent'], 'required'],
            [['uid', 'worker_no', 'worker_level', 'hospital_id', 'department_id', 'patient_state', 'customer_service_id', 'operator_id', 'is_continue'], 'integer'],
            [['base_price', 'patient_state_coefficient', 'total_amount', 'real_amount'], 'number'],
            [['start_time', 'end_time', 'reality_end_time', 'create_time', 'pay_time', 'confirm_time', 'begin_service_time', 'evaluate_time', 'cancel_time'], 'safe'],
            [['order_no'], 'string', 'max' => 50],
            [['worker_name', 'contact_name', 'contact_telephone', 'remark', 'order_status', 'create_order_ip', 'create_order_sources'], 'string', 'max' => 255],

            [['mobile'],'match','pattern'=>'/^[0-9]{11}$/'],
            [['contact_address','create_order_user_agent'], 'string', 'max' => 500],
            [['order_no'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_no' => '订单编号',
            'uid' => '用户ID',
            'contact_name' => '联系人姓名',
            'contact_address' => '联系人地址',
            'contact_telephone' => '备用电话',
            'worker_no' => '护工编号',
            'worker_name' => '护工姓名',
            'worker_level' => '护工等级',
            'mobile' => '用户帐号',
            'base_price' => '护工的基础价格（金额/天）',
            'patient_state_coefficient' => '患者状态价格系数',
            'hospital_id' => '医院',
            'department_id' => '科室',
            'total_amount' => '订单总金额',
            'real_amount' => '实收金额',
            'patient_state' => '患者健康状况',
            'customer_service_id' => '下单客服ID',
            'operator_id' => '订单操作者ID',
            'remark' => '订单备注',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'reality_end_time' => '实际结束时间',
            'create_time' => '订单创建时间',
            'pay_time' => '订单支付时间',
            'confirm_time' => '订单确认时间',
            'begin_service_time' => '开始服务时间',
            'evaluate_time' => '评价时间',
            'cancel_time' => '订单取消时间',
            'order_status' => '订单状态',
            'create_order_ip' => '创建订单的IP',
            'create_order_sources' => '创建订单来源',
            'create_order_user_agent' => '创建订单时客户端user agent',
            'is_continue' => '是否为续单（1：是；0：否）'
        ];
    }

    /**
     * 生成订单号
     * @return string
     * @throws \Exception
     * @author zhangbo
     */
    private function _generateOrderNo(){
        $orderIncrement = new OrderIncrement();
        $orderIncrement->insert();
        return date("Ymd").$orderIncrement->id.str_pad(rand(0, 999), 3, 0, STR_PAD_LEFT);
    }

    /**
     * 创建订单
     * Array(
        [OrderMaster] => Array(
            [mobile] => 13520895446
            [contact_name] => 张三
            [contact_telephone] => 123456789
            [contact_address] => 北京
            [hospital_id] => 2
            [department_id] => 5
            [worker_level] => 2
            [start_time] => 2015-03-24
            [end_time] => 2015-03-30
            [remark] => 快一点
            [uid] => 7
            [patient_state] => 0
            [create_order_sources] => service
        )
        [OrderPatient] => Array(
            [name] => 李国
            [gender] => 1
            [age] => 33
            [height] => 178
            [weight] => 68
            [patient_state] => 0
            [in_hospital_reason] => 被K了
            [admission_date] => 2015-03-21
            [room_no] => 201
            [bed_no] => 3
        )
      )
     * @param array $params
     * @return bool
     * @throws HttpException
     * @author zhangbo
     */
    public function createOrder($params){
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            //生成订单编号
            $orderNo = $this->_generateOrderNo();

            //主订单表数据
            $orderData = $params['OrderMaster'];
            $orderData['order_no'] = $orderNo;
            $orderData['reality_end_time'] = $orderData['end_time'];
            $orderData['create_time'] = date('Y-m-d H:i:s');
            $orderData['create_order_ip'] = $_SERVER["REMOTE_ADDR"];
            $orderData['create_order_user_agent'] = $_SERVER['HTTP_USER_AGENT'];

            //获取护工价格
            if(empty($orderData['is_continue'])){
                if(isset($orderData['worker_no'])){
                    $worker = Worker::findOne($orderData['worker_no']);
                    $orderData['base_price'] = $worker->price;
                }elseif(!empty($orderData['worker_level'])){
                    $orderData['base_price'] = Worker::getWorkerPrice($orderData['worker_level']);
                }
            }

            if(empty($orderData['base_price'])){
                throw new HttpException(400, '无法获取护工价格');
            }

            //能否自理价格系数
            $patientState = $params['OrderPatient']['patient_state'];
            $orderData['patient_state_coefficient'] = OrderPatient::$patientStatePrice[$patientState];

            $orderData['order_status'] = self::ORDER_STATUS_WAIT_PAY;
            $this->attributes = $orderData;
            $totalAmount = $this->calculateTotalPrice();
            $this->total_amount = $totalAmount;
            if (!$this->save()) {
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //保存患者信息
            $orderPatient = $params['OrderPatient'];
            $orderPatient['order_id'] = $this->order_id;
            $orderPatient['order_no'] = $orderNo;
            $orderPatient['create_time'] = date('Y-m-d H:i:s');
            $this->saveOrderPatient($orderPatient);
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            throw new HttpException(400, print_r($e, true));
        }
        return true;
    }

    /**
     * 保存订单患者数据
     * @param $params
     * @return bool
     * @throws HttpException
     * @author zhangbo
     */
    protected function saveOrderPatient($params){
        $orderPatient = new OrderPatient();
        $orderPatient->attributes = $params;
        if($orderPatient->save()){
            return true;
        }else{
            throw new HttpException(400, print_r($orderPatient->getErrors(), true));
        }
    }

    /**
     * 检查订单状态动作
     * @param string $status 订单状态
     * @param string $action 动作
     * @return bool
     * @author zhangbo
     */
    static public function checkOrderStatusAction($status, $action){
        if(in_array($status, self::$orderStatusActions[$action])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 计算价格
     * @param bool $returnDetail 是否返回价格明细
     * @return array|int|mixed
     * @throws ErrorException
     * @throws NotFoundHttpException
     * @author zhangbo
     */
    public function calculateTotalPrice($returnDetail = false){
        $startDate = date('Y-m-d', strtotime($this->start_time));
        $endDate = date('Y-m-d', strtotime($this->reality_end_time));
        if(strtotime($startDate) >= strtotime($endDate)){
            throw new ErrorException('开始时间不能大于结束时间');
        }

        $totalPrice = 0;

        //护工的基础价格（金额/天）
        $basePrice = $this->base_price;

        //获取节假日日期
        $holidaysList = ArrayHelper::map(Holidays::find()->all(), 'id', 'date');

        //获取日期列表
        $dates = $this->getDateList($startDate, $endDate);
        //print_r($dates);exit;

        //价格明细
        $priceDetail = [];

        //能否自理（金额/天）
        $disabledPrice = $basePrice*$this->patient_state_coefficient;

        foreach($dates as $date){
            $detailArr = [
                'dayPrice' => 0,
                'basePrice' => $basePrice,
                'disabledPrice' => 0,
                'holidayPrice' => 0
            ];

            //节假日（金额/天）
            $holidayPrice = 0;
            if(in_array($date, $holidaysList)){
                $holidayPrice = $basePrice * self::HOLIDAY_PRICE_MULTIPLIER - $basePrice;
                $detailArr['holidayPrice'] = number_format($holidayPrice, 2);
            }
            //能否自理（金额/天）
            if($disabledPrice > 0){
                $detailArr['disabledPrice'] = number_format($disabledPrice, 2);
            }
            $dayPrice = $basePrice + $disabledPrice + $holidayPrice;
            $detailArr['dayPrice'] = number_format($dayPrice, 2);
            $priceDetail[$date] = $detailArr;
            $totalPrice += $dayPrice;
        }
        if($returnDetail){
            return ['totalPrice' => number_format($totalPrice, 2), 'PriceDetail' => $priceDetail];
        }
        return $totalPrice;
    }

    /**
     * 获取日期列表
     * @param string $startDate
     * @param string $endDate
     * @return array
     * @author zhangbo
     */
    public function getDateList($startDate, $endDate){
        $dateList = [];
        $number = 0;
        $startDay = date("d", strtotime($startDate));
        $startMonth = date("m", strtotime($startDate));
        $startYear = date("Y", strtotime($startDate));
        $endTime = strtotime($endDate);
        while(true){
            $time = mktime(0, 0, 0, $startMonth, $startDay+$number, $startYear);
            if($time < $endTime){
                $dateList[] = date('Y-m-d', $time);
                $number++;
            }else{
                break;
            }
        }
        return $dateList;
    }

    /**
     * 获取订单周期（天）
     * @param $startTime
     * @param $endTime
     * @return int
     * @author zhangbo
     */
    static public function getOrderCycle($startTime, $endTime){
        $days = (strtotime($endTime) - strtotime($startTime))/86400;
        return intval($days);
    }

    /**
     * 订单支付
     * @param string $remark 备注
     * @return array
     * @throws ErrorException
     * @throws HttpException
     * @throws \yii\db\Exception
     */
    public function pay($remark = null){
        //计算订单总价
        $totalPrice = $this->calculateTotalPrice();
        if($totalPrice <= 0){
            $response = [
                'code' => '500',
                'msg' => '支付失败:订单总价计算错误',
            ];
            return $response;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $response = Wallet::deduction($this->uid, $totalPrice);
            if($response['code'] == '200'){
                //扣款成功，修改订单信息
                //$this->total_amount = $totalPrice;
                $this->order_status = self::ORDER_STATUS_WAIT_CONFIRM;
                $this->pay_time = date('Y-m-d H:i:s');
                $this->operator_id = \Yii::$app->user->id;
                if(!$this->save()) {
                    throw new HttpException(400, print_r($this->getErrors(), true));
                }

                //添加护工排期时间
                if(!empty($this->worker_no)){
                    $workerSchedule = new WorkerSchedule();
                    $workerSchedule->addSchedule($this->order_no, $this->worker_no, $this->start_time, $this->end_time);
                }

                //添加消费记录
                $params = [
                    'order_id' => $this->order_id,
                    'order_no' => $this->order_no,
                    'uid' => $this->uid,
                    'detail_money' => $totalPrice,
                    'detail_type' => WalletUserDetail::WALLET_TYPE_CONSUME,
                    'wallet_money' => $response['money'],
                    'admin_uid' => \Yii::$app->user->id
                ];
                Wallet::addConRecords($params);
            }
            $response['msg'] = '支付成功';
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => '500',
                'msg' => '支付失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }

        //记录操作
        $orderOperatorLog = new OrderOperatorLog();
        $orderOperatorLog->addLog($this->order_no, 'pay', $response, $remark);

        return $response;
    }

    /**
     * 订单确认
     * @param null $remark
     * @return array
     */
    public function confirm($remark = null){
        $response = ['code' => '200'];
        if(!self::checkOrderStatusAction($this->order_status, 'confirm')){
            $response['code'] = '212';
            $response['msg'] = '订单状态错误';
            return $response;
        }
        if(empty($this->worker_no)){
            $response['code'] = '202';
            $response['msg'] = '没有选护工，请选择护工';
            $response['start_time'] = $this->start_time;
            return $response;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->order_status = self::ORDER_STATUS_WAIT_SERVICE;
            $this->confirm_time = date('Y-m-d H:i:s');
            $this->operator_id = \Yii::$app->user->id;
            if(!$this->save()) {
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //记录操作
            $orderOperatorLog = new OrderOperatorLog();
            $orderOperatorLog->addLog($this->order_no, 'confirm', $response, $remark);
            $response['msg'] = '确认成功';
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => '500',
                'msg' => '确认失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }
        return $response;
    }

    /**
     * 订单开始服务
     * @return array
     */
    public function beginService(){
        $response = ['code' => '200'];
        if(!self::checkOrderStatusAction($this->order_status, 'begin_service')){
            $response['code'] = '212';
            $response['msg'] = '订单状态错误';
            return $response;
        }

        //判断时间
        if(strtotime($this->start_time) > strtotime(date('Y-m-d'))){
            $response['code'] = '212';
            $response['msg'] = '开始时间未到';
            return $response;
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->order_status = self::ORDER_STATUS_IN_SERVICE;
            $this->begin_service_time = date('Y-m-d H:i:s');
            $this->operator_id = \Yii::$app->user->id;
            if(!$this->save()) {
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //记录操作
            $orderOperatorLog = new OrderOperatorLog();
            $orderOperatorLog->addLog($this->order_no, 'begin_service', $response);
            $response['msg'] = '开始服务成功';
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => '500',
                'msg' => '开始服务失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }
        return $response;
    }

    /**
     * 订单完成
     * @return array
     */
    public function finish(){
        $response = ['code' => '200'];
        if(!self::checkOrderStatusAction($this->order_status, 'finish')){
            $response['code'] = '212';
            $response['msg'] = '订单状态错误';
            return $response;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->order_status = self::ORDER_STATUS_WAIT_EVALUATE;
            $this->reality_end_time = date('Y-m-d H:i:s');
            $this->operator_id = \Yii::$app->user->id;

            //计算实际金额
            $realAmount = $this->calculateTotalPrice();
            $refundAmount = $this->total_amount - $realAmount;

            //退款
            if($refundAmount > 0){
                $this->real_amount = $realAmount;
                $wallet = Wallet::addMoney($this->uid, $refundAmount);

                //添加退款记录
                $params = [
                    'order_id' => $this->order_id,
                    'order_no' => $this->order_no,
                    'uid' => $this->uid,
                    'detail_money' => $refundAmount,
                    'detail_type' => WalletUserDetail::WALLET_TYPE_REFUND,
                    'wallet_money' => $wallet->money,
                    'admin_uid' => \Yii::$app->user->id
                ];
                Wallet::addConRecords($params);
            }
            if(!$this->save()){
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //删除护工排期时间
            WorkerSchedule::deleteAll(['order_no' => $this->order_no]);

            //记录操作
            $orderOperatorLog = new OrderOperatorLog();
            $orderOperatorLog->addLog($this->order_no, 'finish', $response);
            $response['msg'] = '完成订单成功';
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => '500',
                'msg' => '完成订单处理失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }
        return $response;
    }

    /**
     * 订单取消
     * @return array
     */
    public function cancel(){
        $response = ['code' => '200'];
        if(!self::checkOrderStatusAction($this->order_status, 'cancel')){
            $response['code'] = '212';
            $response['msg'] = '订单状态错误';
            return $response;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            //删除护工排期时间
            WorkerSchedule::deleteAll(['order_no' => $this->order_no]);

            //退款操作
            if(in_array($this->order_status, [self::ORDER_STATUS_WAIT_CONFIRM,self::ORDER_STATUS_WAIT_SERVICE])){
                $refundAmount = $this->total_amount;
                $wallet = Wallet::refundMoney($this->uid, $refundAmount);

                //添加退款记录
                $params = [
                    'order_id' => $this->order_id,
                    'order_no' => $this->order_no,
                    'uid' => $this->uid,
                    'detail_money' => $refundAmount,
                    'detail_type' => WalletUserDetail::WALLET_TYPE_REFUND,
                    'wallet_money' => $wallet->money,
                    'admin_uid' => \Yii::$app->user->id
                ];
                Wallet::addConRecords($params);
            }

            $this->order_status = self::ORDER_STATUS_CANCEL;
            $this->cancel_time = date('Y-m-d H:i:s');
            $this->operator_id = \Yii::$app->user->id;
            if(!$this->save()){
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //记录操作
            $orderOperatorLog = new OrderOperatorLog();
            $orderOperatorLog->addLog($this->order_no, 'cancel', $response);

            $response['msg'] = '取消成功';
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => '500',
                'msg' => '取消失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }

        return $response;
    }

    /**
     * 订单评价
     * @return array
     */
    public function evaluate(){
        $response = ['code' => '200'];
        if(!self::checkOrderStatusAction($this->order_status, 'evaluate')){
            $response['code'] = '212';
            $response['msg'] = '订单状态错误';
            return $response;
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $this->order_status = self::ORDER_STATUS_END_SERVICE;
            $this->evaluate_time = date('Y-m-d H:i:s');
            $this->operator_id = \Yii::$app->user->id;
            if(!$this->save()) {
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //记录操作
            $orderOperatorLog = new OrderOperatorLog();
            $orderOperatorLog->addLog($this->order_no, 'evaluate', $response);
            $response['msg'] = '评价成功';
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => '500',
                'msg' => '评价失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }

        return $response;
    }

    /**
     * 续单
     * @return array
     */
    public function continueOrder(){
        $response = ['code' => '200'];
        if(!self::checkOrderStatusAction($this->order_status, 'continue')){
            $response['code'] = '212';
            $response['msg'] = '订单状态错误';
            return $response;
        }

        //记录操作
        $orderOperatorLog = new OrderOperatorLog();
        $orderOperatorLog->addLog($this->order_no, 'continue', $response);
        return $response;
    }


    /**
     * 设置选择的护工
     * @param $orderId
     * @param $workerId
     * @param $workerName
     * @return array
     */
    static public function setWorker($orderId, $workerId, $workerName){
        $response = ['code' => '200', 'msg' => ''];
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $order = self::findOne($orderId);
            if(empty($order)){
                $response['code'] = '404';
                $response['msg'] = '找不到订单';
                return $response;
            }
            //判断是是否已选择护工
            if(!empty($order->worker_no)){
                $response['code'] = '200';
                $response['msg'] = '已选择护工';
                return $response;
            }

            $order->worker_no = $workerId;
            $order->worker_name = $workerName;
            $order->save();

            //添加护工排期时间
            $workerSchedule = new WorkerSchedule();
            $workerSchedule->addSchedule($order->order_no, $order->worker_no, $order->start_time, $order->end_time);

            $transaction->commit();
            $response['msg'] = '选择护工成功';
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => '500',
                'msg' => '选择的护工失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }
        return $response;
    }


}