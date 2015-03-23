<?php

namespace backend\models;

use Yii;
use common\models\Order;

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
class OrderMaster extends Order
{

}
