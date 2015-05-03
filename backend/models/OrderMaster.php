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
    const IS_CONTINUE_YES = 1; //是续单
    const IS_CONTINUE_NO = 0; //不是续单

    public function rules(){
        $rules = parent::rules();
        return array_merge($rules, [
            [['worker_level'], 'required'],
            [['reality_end_time'], 'required', 'on'=>['calculate', 'update']],
            [['reality_end_time'], 'validateRealityEndTime', 'on'=>['calculate', 'update']],
            [['patient_state'], 'required', 'on'=>'calculate'],

        ]);
    }

    /**
     * 验证实际结束时间
     * @param $attribute
     */
    public function validateRealityEndTime($attribute){
        if (!$this->hasErrors()) {
            if(strtotime($this->reality_end_time) > strtotime($this->end_time)){
                $this->addError($attribute, '实际结束时间不能大于订单结束时间。');
            }
            if(strtotime($this->reality_end_time) <= strtotime($this->start_time)){
                $this->addError($attribute, '实际结束时间不能小于或等于订单开始时间。');
            }
//            if(strtotime($this->reality_end_time) <= strtotime(date('Y-m-d'))){
//                $this->addError($attribute, '实际结束时间不能小于或等于当前时间。');
//            }
        }
    }

    /**
     * @param $mobile
     * @param null $name
     * @return $this|User|null|static
     * @throws \backend\models\ErrorException
     */
    public function checkMobile($mobile, $name = null){
        $user = User::findOne(['mobile' => $mobile]);
        if(empty($user)){
            //注册手机号
            $user = new User();
            $user->mobile = $mobile;
            $user->name = $name;
            $user = $user->SystemSignUp();
        }
        return $user;
    }


}
