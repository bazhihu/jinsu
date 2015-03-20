<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%order_master}}".
 *
 * @property string $order_id
 * @property string $order_no
 * @property string $uid
 * @property string $worker_no
 * @property string $worker_name
 * @property integer $worker_level
 * @property string $mobile
 * @property string $base_price
 * @property string $disabled_amount
 * @property string $hospital_id
 * @property string $department_id
 * @property string $holidays
 * @property string $total_amount
 * @property integer $patient_state
 * @property string $customer_service_id
 * @property string $operator_id
 * @property string $start_time
 * @property string $end_time
 * @property string $reality_end_time
 * @property string $create_time
 * @property string $pay_time
 * @property string $confirm_time
 * @property string $begin_service_time
 * @property string $evaluate_time
 * @property string $cancel_time
 * @property string $order_status
 * @property string $create_order_ip
 * @property string $create_order_sources
 * @property string $create_order_user_agent
 */
class OrderMaster extends \yii\db\ActiveRecord
{
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
            [['order_no', 'worker_level', 'mobile', 'base_price', 'start_time', 'end_time', 'reality_end_time', 'create_time', 'create_order_ip', 'create_order_sources', 'create_order_user_agent'], 'required'],
            [['uid', 'worker_no', 'worker_level', 'hospital_id', 'department_id', 'patient_state', 'customer_service_id', 'operator_id'], 'integer'],
            [['base_price', 'disabled_amount', 'total_amount'], 'number'],
            [['start_time', 'end_time', 'reality_end_time', 'create_time', 'pay_time', 'confirm_time', 'begin_service_time', 'evaluate_time', 'cancel_time'], 'safe'],
            [['order_no'], 'string', 'max' => 50],
            [['worker_name', 'holidays', 'order_status', 'create_order_ip', 'create_order_sources'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 11],
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
            'order_id' => 'Order ID',
            'order_no' => '订单编号',
            'uid' => '用户ID',
            'worker_no' => '护工编号',
            'worker_name' => '护工姓名',
            'worker_level' => '护工等级（5：中级；6：高级；7：特级；8：金牌）',
            'mobile' => '下单手机号',
            'base_price' => '护工的基础价格（金额/天）',
            'disabled_amount' => '不能自理每天所加金额',
            'hospital_id' => '医院ID',
            'department_id' => '科室ID',
            'holidays' => '节假日',
            'total_amount' => '订单总金额',
            'patient_state' => '患者健康情况（0：不能自理；1：能自理）',
            'customer_service_id' => '下单客服ID',
            'operator_id' => '订单操作者ID',
            'start_time' => '服务开始时间',
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
}
