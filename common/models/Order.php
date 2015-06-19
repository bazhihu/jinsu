<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/3/21
 * Time: 18:25
 */
namespace common\models;

use backend\models\Patient;
use Yii;
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

    static public $orderSources = [
        self::ORDER_SOURCES_WEB => '网站',
        self::ORDER_SOURCES_MOBILE => '移动客户端',
        self::ORDER_SOURCES_SERVICE => '客服后台',
    ];

    //订单支付方式
    const PAY_WAY_CASH = 1; //现金
    const PAY_WAY_ALIPAY = 2; //支付宝
    const PAY_WAY_WE_CHAT = 3; //微信
    static public $orderPayWayLabels = [
        self::PAY_WAY_CASH => '现金',
        self::PAY_WAY_ALIPAY => '支付宝',
        self::PAY_WAY_WE_CHAT => '微信'
    ];

    //下单类型
    const ORDER_TYPE_FAST = 1; //快速下单
    const ORDER_TYPE_WORKER = 2; //选择护工下单

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
        self::ORDER_STATUS_CANCEL => '已取消',
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
            self::ORDER_STATUS_WAIT_PAY,
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
            self::ORDER_STATUS_WAIT_CONFIRM,
            self::ORDER_STATUS_IN_SERVICE,
            self::ORDER_STATUS_END_SERVICE,
            self::ORDER_STATUS_WAIT_EVALUATE
        ],
        //评价
        'evaluate' => [
            self::ORDER_STATUS_WAIT_EVALUATE
        ],
        //复制订单
        'copy' => [
            self::ORDER_STATUS_END_SERVICE,
            self::ORDER_STATUS_WAIT_EVALUATE,
            self::ORDER_STATUS_CANCEL
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
            [['order_no', 'mobile', 'city_id','hospital_id', 'department_id', 'base_price', 'patient_state', 'start_time', 'end_time', 'reality_end_time', 'order_type'], 'required'],
            [['uid', 'worker_no', 'worker_level', 'hospital_id', 'department_id', 'patient_state', 'pay_way', 'customer_service_id', 'operator_type', 'operator_id', 'is_continue', 'order_type'], 'integer'],
            [['base_price', 'patient_state_coefficient', 'total_amount', 'real_amount'], 'number'],
            [['reality_end_time', 'create_time', 'pay_time', 'confirm_time', 'begin_service_time', 'evaluate_time', 'cancel_time'], 'safe'],
            [['order_no'], 'string', 'max' => 50],
            [['worker_name', 'contact_name', 'patient_name', 'contact_telephone', 'remark', 'order_status', 'create_order_ip', 'create_order_sources'], 'string', 'max' => 255],

            [['mobile'],'match','pattern'=>'/^[0-9]{11}$/'],
            [['contact_address','create_order_user_agent'], 'string', 'max' => 500],
            [['order_no'], 'unique'],
            [['end_time'], 'validateEndTime']
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
            'mobile' => '手机号',
            'base_price' => '护工基础价格',
            'patient_state_coefficient' => '患者状态价格系数',
            'city_id' => '城市',
            'hospital_id' => '医院',
            'department_id' => '科室',
            'total_amount' => '订单金额',
            'real_amount' => '实收金额',
            'patient_state' => '患者健康状况',
            'patient_name' => '患者姓名',
            'customer_service_id' => '下单客服',
            'operator_id' => '订单操作者',
            'remark' => '订单备注',
            'start_time' => '订单开始时间',
            'end_time' => '订单结束时间',
            'pay_way' => '支付方式',
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
            'is_continue' => '是否为续单（1：是；0：否）',
            'order_type' => '下单类型（1：快速下单；2：选择护工下单）'
        ];
    }

    public function validateEndTime($attribute){
        if (!$this->hasErrors()) {
            if(strtotime($this->end_time) <= strtotime($this->start_time)){
                $this->addError($attribute, '结束时间不能小于或等于开始时间。');
            }
        }
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
     * 创建订
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
            $orderData['patient_name'] = isset($params['OrderPatient']['name']) ? $params['OrderPatient']['name'] : null;

            //获取护工价格
            if(empty($orderData['is_continue'])){
                if(isset($orderData['worker_no'])){
                    $worker = Worker::findOne($orderData['worker_no']);
                    $orderData['base_price'] = $worker->price;
                    $orderData['worker_name'] = $worker->name;
                    $orderData['worker_level'] = $worker->level;
                    $orderData['order_type'] = self::ORDER_TYPE_WORKER;
                }elseif(!empty($orderData['worker_level'])){
                    empty($orderData['base_price']) && $orderData['base_price'] = Worker::getWorkerPrice($orderData['worker_level']);
                    $orderData['order_type'] = self::ORDER_TYPE_FAST;
                }
            }

            if(empty($orderData['base_price'])){
                throw new HttpException(400, '无法获取护工价格');
            }

            //城市判断
            if(empty($orderData['city_id'])){
                $orderData['city_id'] = 110100;
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
            $this->_saveOrderPatient($orderPatient);

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
    protected function _saveOrderPatient($params){
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
     * @throws HttpException
     * @throws NotFoundHttpException
     * @author zhangbo
     */
    public function calculateTotalPrice($returnDetail = false){
        $startDate = date('Y-m-d', strtotime($this->start_time));
        $endDate = date('Y-m-d', strtotime($this->reality_end_time));
        if(strtotime($startDate) >= strtotime($endDate)){
            throw new HttpException(400, '订单时间错误');
        }

        $totalPrice = 0;

        //护工的基础价格（金额/天）
        $basePrice = $this->base_price;

        //获取节假日日期
        $holidaysList = ArrayHelper::map(Holidays::find()->all(), 'id', 'date');

        //获取日期列表
        $dates = self::getDateList($startDate, $endDate);
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
    static public function getDateList($startDate, $endDate){
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
        $totalPrice = $this->total_amount;
        if($totalPrice <= 0){
            $response = [
                'code' => 500,
                'msg' => '支付失败:订单总价计算错误',
            ];
            return $response;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $response = Wallet::deduction($this->uid, $totalPrice);
            if($response['code'] == '200'){
                //扣款成功，修改订单信息
                $this->order_status = self::ORDER_STATUS_WAIT_CONFIRM;
                $this->pay_time = date('Y-m-d H:i:s');
                $this->operator_id = Yii::$app->user->id;
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
                    'admin_uid' => Yii::$app->user->id
                ];
                Wallet::addUserDetail($params);
                $response['msg'] = '支付成功';
            }

            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => 500,
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
     * 订单取消
     * @param string $reason 取消原因
     * @param int $operatorType 操作者类型
     * @return array
     */
    public function cancel($reason = null, $operatorType = 1){
        $response = ['code' => 200];
        if(!self::checkOrderStatusAction($this->order_status, 'cancel')){
            $response['code'] = 212;
            $response['msg'] = '订单状态错误';
            return $response;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            //删除护工排期时间
            WorkerSchedule::deleteAll(['order_no' => $this->order_no]);

            //退款操作
            if(!in_array($this->order_status, [self::ORDER_STATUS_WAIT_PAY,self::ORDER_STATUS_CANCEL])){
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
                    'admin_uid' => Yii::$app->user->id
                ];
                Wallet::addUserDetail($params);
            }

            $this->order_status = self::ORDER_STATUS_CANCEL;
            $this->cancel_time = date('Y-m-d H:i:s');
            $this->operator_type = $operatorType;
            $this->operator_id = Yii::$app->user->id;
            if(!$this->save()){
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //记录操作
            $orderOperatorLog = new OrderOperatorLog();
            $orderOperatorLog->addLog($this->order_no, 'cancel', $response, $reason);

            $response['msg'] = '取消成功';
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => 500,
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
        $response = ['code' => 200];
        if(!self::checkOrderStatusAction($this->order_status, 'evaluate')){
            $response['code'] = 212;
            $response['msg'] = '订单状态错误';
            return $response;
        }
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $this->order_status = self::ORDER_STATUS_END_SERVICE;
            $this->evaluate_time = date('Y-m-d H:i:s');
            $this->operator_id = Yii::$app->user->id;
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
                'code' => 500,
                'msg' => '评价失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }

        return $response;
    }

    /**
     * @param bool $insert
     * @return bool|void
     */
    public function beforeSave($insert){
        if ($insert && parent::beforeSave($insert)) {
            $this->create_time = date('Y-m-d H:i:s');
            $this->create_order_ip = $_SERVER["REMOTE_ADDR"];
            $this->create_order_user_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        $this->start_time = date('Y-m-d 09:00:00', strtotime($this->start_time));
        $this->end_time = date('Y-m-d 09:00:00', strtotime($this->end_time));
        $this->reality_end_time = date('Y-m-d 09:00:00', strtotime($this->reality_end_time));
        return true;
    }

}