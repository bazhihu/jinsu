<?php
/**
 * 订单相关定时任务程序
 * User: zhangbo
 * Date: 2015/4/20
 * Time: 17:43
 */

namespace console\controllers;

use backend\models\OrderMaster;
use Yii;
use common\models\Order;
use common\models\Sms;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class OrderController extends Controller {
    /**
     * 订单结束服务提醒
     */
    public function actionEnd(){
        Yii::info('Game begin', 'console');

        //获取还有一天将要结束的订单
        $dateTime = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+1, date('Y')));
        $orderModel = Order::findAll(['reality_end_time' => $dateTime]);
        $orderArr = ArrayHelper::toArray($orderModel);
        foreach($orderArr as $order){
            $params = [
                'time' => $order['reality_end_time'],
                'mobile' => $order['mobile'],
                'type' => Sms::SMS_ORDERS_OVER
            ];
            $response = Sms::send($params);
            $log = 'mobile:'.$order['mobile'].' code:'.$response['code'].' msg:'.$response['msg']."\n";
            //echo $log;
            Yii::info($log, 'console');
        }
        Yii::info('Game Over', 'console');
    }

    /**
     * 自动完成订单
     */
    public function actionAutoComplete(){
        Yii::info('Game begin', 'console');

        //获取当前时间要结束的订单
        $dateTime = date('Y-m-d');
        $orders = Order::findAll(['reality_end_time' => $dateTime, 'order_status' => Order::ORDER_STATUS_IN_SERVICE]);
        foreach($orders as $order){
            $orderModel = OrderMaster::findOne($order->order_id);
            $response = $orderModel->finish(strtotime($dateTime));
            $log = 'OrderNo:'.$order->order_no.' OrderStatus:'.$order->order_status;
            $log .= ' $responseCode:'.$response['code'].' $responseMsg:'.$response['msg'];
            Yii::info($log, 'console');
        }
        Yii::info('Game Over', 'console');
    }
}