<?php

namespace backend\models;

use Yii;
use yii\base\Exception;
use yii\web\HttpException;
use common\models\Order;
use common\models\Sms;
use common\models\Wallet;

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
    const PROFIT = 20; //每天利润20元

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

    /**
     * @return mixed
     */
    public function formatMobile(){
        //$roles = [AdminUser::BACKOFFICESTAFF, AdminUser::BACKSYSTEMADMIN];
        //if(in_array(Yii::$app->user->identity->staff_role, $roles)){
            return $this->mobile;
        //}
        //return substr_replace($this->mobile, '****', 3, 4);
    }

    /**
     * 订单确认
     * @param null $remark
     * @return array
     * @throws HttpException
     * @throws \yii\db\Exception
     */
    public function confirm($remark = null){
        $response = ['code' => 200];
        if(!self::checkOrderStatusAction($this->order_status, 'confirm')){
            $response['code'] = 212;
            $response['msg'] = '订单状态错误';
            return $response;
        }
        if(empty($this->worker_no)){
            $response['code'] = 202;
            $response['msg'] = '没有选护工，请选择护工';
            $response['start_time'] = $this->start_time;
            return $response;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try{
            $this->order_status = self::ORDER_STATUS_WAIT_SERVICE;
            $this->confirm_time = date('Y-m-d H:i:s');
            $this->operator_id = Yii::$app->user->id;
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
                'code' => 500,
                'msg' => '确认失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }

        //发送短信
        if($response['code'] == 200){
            $params['mobile'] = $this->mobile;
            $params['type'] = Sms::SMS_ORDERS_SUCCESSFUL_PAYMENT;
            $params['time'] = $this->start_time;
            $params['level'] = Worker::$workerLevelLabel[$this->worker_level];
            Sms::send($params);
        }

        return $response;
    }

    /**
     * 订单开始服务
     * @return array
     * @throws HttpException
     * @throws \yii\db\Exception
     */
    public function beginService(){
        $response = ['code' => 200];
        if(!self::checkOrderStatusAction($this->order_status, 'begin_service')){
            $response['code'] = 212;
            $response['msg'] = '订单状态错误';
            return $response;
        }

        //判断时间
        $startTime = date('Y-m-d', strtotime($this->start_time));
        if(strtotime($startTime) > strtotime(date('Y-m-d'))){
            $response['code'] = 212;
            $response['msg'] = '开始时间未到';
            return $response;
        }
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $this->order_status = self::ORDER_STATUS_IN_SERVICE;
            $this->begin_service_time = date('Y-m-d H:i:s');
            $this->operator_id = Yii::$app->user->id;
            if(!$this->save()) {
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //记录操作
            $orderOperatorLog = new OrderOperatorLog();
            $orderOperatorLog->addLog($this->order_no, 'begin_service', $response);
            $response['msg'] = '开始服务成功';
            $transaction->commit();
        }catch (ErrorException $e){
            $transaction->rollBack();
            $response = [
                'code' => 500,
                'msg' => '开始服务失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }
        return $response;
    }

    /**
     * 订单完成
     * @param string $endTime 结束时间
     * @return array
     */
    public function finish($endTime = null){
        $response = ['code' => 200];
        if(!self::checkOrderStatusAction($this->order_status, 'finish')){
            $response['code'] = 212;
            $response['msg'] = '订单状态错误';
            return $response;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try{
            $this->order_status = self::ORDER_STATUS_WAIT_EVALUATE;
            $this->operator_id = isset(Yii::$app->user) ? Yii::$app->user->id : 0;
            if(!empty($endTime)){
                if(strtotime($endTime) > strtotime($this->end_time)){
                    $response['code'] = 212;
                    $response['msg'] = '实际结束时间不能大于订单结束时间';
                    return $response;
                }
                if(strtotime($endTime) <= strtotime($this->start_time)){
                    $response['code'] = 212;
                    $response['msg'] = '实际结束时间不能小于或等于订单开始时间';
                    return $response;
                }
                $this->reality_end_time = $endTime;
            }

            //计算实际金额
            $realAmount = $this->calculateTotalPrice();
            $refundAmount = $this->total_amount - $realAmount;
            $this->real_amount = $realAmount;

            //退款
            if($refundAmount > 0){
                $wallet = Wallet::addMoney($this->uid, $refundAmount);

                //添加退款记录
                $params = [
                    'order_id' => $this->order_id,
                    'order_no' => $this->order_no,
                    'uid' => $this->uid,
                    'detail_money' => $refundAmount,
                    'detail_type' => WalletUserDetail::WALLET_TYPE_REFUND,
                    'wallet_money' => $wallet->money,
                    'admin_uid' => $this->operator_id
                ];
                Wallet::addUserDetail($params);
            }

            if(!$this->save()){
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //删除护工排期时间
            WorkerSchedule::deleteAll(['order_no' => $this->order_no]);

            //记录操作
            $orderOperatorLog = new OrderOperatorLog();
            $orderOperatorLog->addLog($this->order_no, 'finish', $response);

            //给护工加订单总数
            Worker::plusTotalOrder($this->worker_no);

            //@TODO...记录护工订单收入


            $response['msg'] = '完成订单成功';
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            $response = [
                'code' => 500,
                'msg' => '完成订单处理失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }

        //发送短信
        if($response['code'] == 200){
            $params['mobile'] = $this->mobile;
            $params['type'] = Sms::SMS_ORDERS_COMPLETED;
            $params['days'] = self::getOrderCycle($this->start_time, $this->reality_end_time);
            $params['level'] = Worker::$workerLevelLabel[$this->worker_level];
            Sms::send($params);
        }
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
        $response = ['code' => 200, 'msg' => ''];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $order = self::findOne($orderId);
            if(empty($order)){
                $response['code'] = 404;
                $response['msg'] = '找不到订单';
                return $response;
            }
            //判断是是否已选择护工
            if(!empty($order->worker_no)){
                $response['code'] = 200;
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
                'code' => 500,
                'msg' => '选择的护工失败:'.$e->getMessage(),
                'errorMsg' => $e->getMessage()
            ];
        }
        return $response;
    }


}
