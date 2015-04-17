<?php

namespace common\models;

use backend\models\OrderMaster;
use Yii;

/**
 * @author zhiqiang
 * 用户评价
 */
class Comment
{

    const COMMENT_PENDING = 1;//待审核

    const COMMENT_TYPE_USER = 'user';//待审核

    public static function createComment($comment)
    {

        if(!$comment['star'] || !$comment['order_no'] || !$comment['uid'] || !$comment['content']) {
            return false;
        }

        $commentMast = new \backend\models\Comment();

        $params['star']         = $comment['star'];
        $params['uid']          = $comment['uid'];
        $params['content']      = $comment['content'];
        $params['order_no']     = $comment['order_no'];
        $params['status']       = $comment['status'];
        $params['comment_date'] = date('Y-m-d H:i:s');
        $params['type']         = $comment['type'];
        //查找订单表，找护工编号,护工姓名
        $order_info = OrderMaster::findOne(['order_no' => $params['order_no']]);
        $params['worker_name'] = $order_info['worker_name'];
        $params['worker_id'] = $order_info['worker_no'];
        //$params['uid'] = $order_info['uid'];
        $params['comment_ip'] = Yii::$app->request->userIP;

        #更新订单状态
        $orderModel = Order::findOne(['order_no'=>$comment['order_no']]);
        if($orderModel){
            $eva = $orderModel->evaluate();
            if($eva['code']!=200){
                return false;
            }
        }

        $commentMast->attributes = $params;
        if(!$commentMast->save())
        {
            return false;
        }
        return true;
    }

}