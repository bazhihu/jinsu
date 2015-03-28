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
    /**
     * 订单确认
     * @param null $remark
     * @return array
     */
    public function confirm($remark = null){
        $response = ['code' => '200'];

        if(empty($this->worker_no)){
            $response['code'] = '202';
            $response['msg'] = '没有选护工，请选择护工';
            $response['start_time'] = $this->start_time;
            return $response;
        }

        $this->order_status = self::ORDER_STATUS_WAIT_SERVICE;
        $this->confirm_time = date('Y-m-d H:i:s');
        if($this->save()) {
            $response['msg'] = '确认成功';
        }else{
            $response['code'] = '412';
            $response['msg'] = '确认失败';
        }

        //记录操作
        $orderOperatorLog = new OrderOperatorLog();
        $orderOperatorLog->addLog($this->order_no, 'confirm', $response, $remark);
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
        $order = OrderMaster::findOne($orderId);
        if(empty($order)){
            $response['code'] = '404';
            $response['msg'] = '找不到订单';
            return $response;
        }
        $order->worker_no = $workerId;
        $order->worker_name = $workerName;
        if($order->save()){
            //改变订单状态为开始服务
            $order->confirm('后台选择护工下单');

            $response['msg'] = '选择护工成功';
            return $response;
        }else{
            $response['code'] = '500';
            $response['msg'] = '选择护工失败：'.print_r($order->getErrors());
            return $response;
        }
    }

}
