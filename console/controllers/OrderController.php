<?php
/**
 * 订单相关定时任务程序
 * User: zhangbo
 * Date: 2015/4/20
 * Time: 17:43
 */

namespace console\controllers;

use common\models\Order;
use yii\console\Controller;

class OrderController extends Controller {
    /**
     * 订单结束服务提醒
     */
    public function actionEnd(){
        //获取还有一天将要结束的订单
        $time = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+1, date('Y')));
        $orderModel = Order::find();

    }
}