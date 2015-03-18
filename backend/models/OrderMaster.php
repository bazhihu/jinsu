<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%order_master}}".
 *
 * @property string $id
 * @property string $order_no
 * @property string $uid
 * @property string $mobile
 * @property string $base_price
 * @property string $disabled_amount
 * @property string $holiday_amount
 * @property string $total_amount
 * @property integer $patient_state
 * @property integer $worker_level
 * @property string $customer_service_id
 * @property string $operator_id
 * @property string $service_start_time
 * @property string $service_end_time
 * @property string $reality_end_time
 * @property string $create_time
 * @property string $pay_time
 * @property string $confirm_time
 * @property string $cancel_time
 * @property string $order_status
 * @property string $create_order_ip
 * @property string $create_order_sources
 * @property string $create_order_user_agent
 */
class OrderMaster extends \yii\db\ActiveRecord
{
    const ORDER_STATUS_WAIT_PAY = 'wait_pay'; //待支付
    const ORDER_STATUS_WAIT_CONFIRM = 'wait_confirm'; //待确认
    const ORDER_STATUS_WAIT_SERVICE = 'wait_service'; //待服务
    const ORDER_STATUS_IN_SERVICE = 'in_service'; //服务中
    const ORDER_STATUS_END_SERVICE = 'end_service'; //结束服务
    const ORDER_STATUS_CANCEL = 'cancel'; //取消订单
    const ORDER_STATUS_WAIT_EVALUATE = 'wait_evaluate'; //待评价

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
            [['order_no', 'mobile', 'base_price', 'worker_level', 'service_start_time', 'service_end_time', 'reality_end_time', 'create_time', 'create_order_ip', 'create_order_sources', 'create_order_user_agent'], 'required'],
            [['uid', 'patient_state', 'worker_level', 'customer_service_id', 'operator_id'], 'integer'],
            [['base_price', 'disabled_amount', 'holiday_amount', 'total_amount'], 'number'],
            [['service_start_time', 'service_end_time', 'reality_end_time', 'create_time', 'pay_time', 'confirm_time', 'cancel_time'], 'safe'],
            [['order_no'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 11],
            [['order_status', 'create_order_ip', 'create_order_sources'], 'string', 'max' => 255],
            [['create_order_user_agent'], 'string', 'max' => 500],
            [['order_no'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => '订单编号',
            'uid' => '用户ID',
            'mobile' => '联系人手机号码',
            'base_price' => '护工的基础价格',
            'disabled_amount' => '不能自理所加金额',
            'holiday_amount' => '节假日所加金额',
            'total_amount' => '订单总金额',
            'patient_state' => '患者健康情况',
            'worker_level' => '护工等级',
            'customer_service_id' => '下单客服ID',
            'operator_id' => '订单操作者ID',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'reality_end_time' => '实际结束时间',
            'create_time' => '订单创建时间',
            'pay_time' => '订单支付时间',
            'confirm_time' => '订单确认时间',
            'begin_service_time' => '开始服务时间',
            'cancel_time' => '订单取消时间',
            'order_status' => '订单状态',
            'create_order_ip' => '创建订单的IP',
            'create_order_sources' => '创建订单来源',
            'create_order_user_agent' => '创建订单时客户端user agent',
        ];
    }
}
