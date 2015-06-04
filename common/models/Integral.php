<?php

namespace common\models;

use backend\models\Comment;
use backend\models\Worker;
use backend\models\WorkerIntegral;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;


class Integral
{
    /**
     * @param $params
     * [
     *      'worker_id' =>'护工编号',
     *      'type'      =>'积分类型',
     *      'integral'  =>'积分',
     * ]
     * @return array
     * @throws HttpException
     */
    public static function addWorkerIntegral($params){
        $response = [
            'code'  =>'200',
            'msg'   =>'',
        ];
        #更新积分总数
        $score = self::updateTotalScore($params['worker_id'],$params['integral']);
        if($score['code'] != 200){
            return $score;
        }

        $integral = new WorkerIntegral();

        $params['time'] = date('Y-m-d H:i:s');
        $params['cumulative'] = $score['total'];
        $params['remarks'] = WorkerIntegral::$IntegralType[$params['type']];

        $integral->setAttributes($params,false);
        if(!$integral->save()){
            throw new HttpException(400, print_r($integral->getErrors(), true));
        }
        $response['msg'] = '记录成功';
        return $response;
    }

    /**
     * 更新护工积分
     * @param $worker_id 护工编号
     * @param $score    护工积分
     * @return array
     */
    public static function updateTotalScore($worker_id,$score){
        $response = [
            'code' => '200',
        ];
        $worker = Worker::findOne(['worker_id'=>$worker_id]);

        $worker->total_score = $worker->total_score + $score;
        if($worker->save()){
            $response['total'] = $worker->total_score;
        }else{
            $response['code'] = 400;
        }
        return $response;
    }

    /**
     * 获取积分
     * @param $type
     * @param $params
     */
    public static function integralCalculus($type,$params){
        $score = 0;
        switch($type) {
            case WorkerIntegral::WORKER_INTEGRAL_TYPE_ONE :
                $score = self::evaluationIntegral($params);
                break;
            default:
                break;
        }
        return $score;
    }

    /**
     * 评价订单获取的积分
     * @param $params
     * [
     *      'comment_id'=>'评价id'
     *      'star'=>'星级'
     * ]
     * @return int
     */
    protected static function evaluationIntegral($params){
        $comment_id = $params['comment_id'];
        try {
            $comment = Comment::findOne(['comment_id'=>$comment_id]);
            $order_no  = $comment->order_no;
        }catch (Exception $e){
            throw new HttpException(400, print_r($e, true));
        }

        if($order_no){
            try {
                $order = Order::findOne(['order_no'=>$order_no]);
                $start_time = $order->start_time;
                $end_time = $order->reality_end_time;
            }catch (Exception $e){
                throw new HttpException(400, print_r($e, true));
            }
            return Order::getOrderCycle($start_time,$end_time)*$comment->star;
        }
    }
}