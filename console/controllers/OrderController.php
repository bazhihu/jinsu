<?php
/**
 * 订单相关定时任务程序
 * User: zhangbo
 * Date: 2015/4/20
 * Time: 17:43
 */

namespace console\controllers;

use yii\console\Controller;

class OrderController extends Controller {
    /**
     * 订单结束服务提醒
     */
    public function actionEnd(){
        echo "end";
    }
}