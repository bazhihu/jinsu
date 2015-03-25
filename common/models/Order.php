<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/3/21
 * Time: 18:25
 */
namespace common\models;

use backend\models\OrderIncrement;
use backend\models\OrderPatient;
use backend\Models\Worker;
use yii\web\HttpException;

class Order extends \yii\db\ActiveRecord{
    //订单来源
    const ORDER_SOURCES_WEB = 'web'; //web网站
    const ORDER_SOURCES_MOBILE = 'mobile'; //移动客户端
    const ORDER_SOURCES_SERVICE = 'service'; //客服

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

    //订单状态动作配置
    static public $orderStatusActions = [
        //支付
        'pay' => [
            self::ORDER_STATUS_WAIT_PAY
        ],
        //更新
        'update' => [
            self::ORDER_STATUS_WAIT_CONFIRM,
            self::ORDER_STATUS_WAIT_SERVICE,
            self::ORDER_STATUS_IN_SERVICE
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
            [['order_no', 'worker_level', 'mobile', 'hospital_id', 'department_id', 'base_price', 'start_time', 'end_time', 'reality_end_time', 'create_time', 'create_order_ip', 'create_order_sources', 'create_order_user_agent'], 'required'],
            [['uid', 'worker_no', 'worker_level', 'hospital_id', 'department_id', 'patient_state', 'customer_service_id', 'operator_id'], 'integer'],
            [['base_price', 'disabled_amount', 'total_amount'], 'number'],
            [['start_time', 'end_time', 'reality_end_time', 'create_time', 'pay_time', 'confirm_time', 'begin_service_time', 'evaluate_time', 'cancel_time'], 'safe'],
            [['order_no'], 'string', 'max' => 50],
            [['worker_name', 'contact_name', 'contact_telephone', 'holidays', 'remark', 'order_status', 'create_order_ip', 'create_order_sources'], 'string', 'max' => 255],

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
            'disabled_amount' => '不能自理每天所加金额',
            'hospital_id' => '医院',
            'department_id' => '科室',
            'holidays' => '节假日',
            'total_amount' => '订单总金额',
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
        ];
    }

    /**
     * 生成订单号
     * @return string
     * @throws \Exception
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
     */
    public function createOrder($params){
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            //生成订单编号
            $orderNo = $this->_generateOrderNo();

            //主订单表数据
            $orderMasterData = $params['OrderMaster'];
            $orderMasterData['order_no'] = $orderNo;
            $orderMasterData['reality_end_time'] = $orderMasterData['end_time'];
            $orderMasterData['create_time'] = date('Y-m-d H:i:s');
            $orderMasterData['create_order_ip'] = $_SERVER["REMOTE_ADDR"];
            $orderMasterData['create_order_user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $orderMasterData['base_price'] = Worker::getWorkerPrice($orderMasterData['worker_level']);
            $orderMasterData['order_status'] = self::ORDER_STATUS_WAIT_PAY;
            $this->attributes = $orderMasterData;
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

    public function calculateTotalPrice($orderNo){
        $order = $this->findOne(['order_no' => $orderNo]);
        //护工的基础价格（金额/天）
        $basePrice = $order->base_price;

        //能否自理（金额/天）
        $ratio = OrderPatient::$patientStatePrice[$order->patient_state];
        $disabledPrice = $basePrice+($basePrice*$ratio);

        //节假日（金额/天）


    }

}