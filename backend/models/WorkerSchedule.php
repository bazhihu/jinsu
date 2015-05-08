<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%worker_schedule}}".
 *
 * @property string $id
 * @property string $order_no
 * @property string $worker_id
 * @property string $start_date
 * @property string $end_date
 */
class WorkerSchedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%worker_schedule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_no', 'worker_id', 'start_date', 'end_date'], 'required'],
            [['worker_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['order_no'], 'string', 'max' => 50],
            [['order_no'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => '订单',
            'worker_id' => '护工ID',
            'start_date' => '开始日期',
            'end_date' => '结束日期',
        ];
    }

    /**
     * 添加护工排期
     * @param string $orderNo 订单编号
     * @param int $workerNo 护工编号
     * @param string $startDate 开始日期
     * @param string $endDate 结束日期
     * @return bool
     */
    public function addSchedule($orderNo, $workerNo, $startDate, $endDate){
        $data = [
            'order_no' => $orderNo,
            'worker_id' => $workerNo,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        $this->setAttributes($data);
        return $this->save();
    }

    /**
     * 获取给予日期在工作中的护工
     * @param string $startDate
     * @param string $endDate
     * @return array
     * @author zhangbo
     */
    static public function getWorkingByDate($startDate, $endDate = null){
        $sql = 'SELECT id,worker_id FROM '.self::tableName();
        $sql .= "WHERE UNIX_TIMESTAMP(start_date)<=UNIX_TIMESTAMP('$startDate') AND UNIX_TIMESTAMP('$startDate')<UNIX_TIMESTAMP(end_date)";

        if($endDate){
            $sql .= " AND UNIX_TIMESTAMP(start_date)>UNIX_TIMESTAMP('$endDate') AND UNIX_TIMESTAMP('$endDate')<=UNIX_TIMESTAMP(end_date)";
        }
        $workers = self::findBySql($sql)->all();

        return ArrayHelper::map($workers, 'id', 'worker_id');
    }

    /**
     * 判断某护工在给予的日期是否在工作中
     * @param $workerId
     * @param $date
     * @return bool
     */
    static public function isWorking($workerId, $date){
        $workerIds = self::getWorkingByDate($date);
        if(in_array($workerId, $workerIds)){
            return true;
        }
        return false;

    }
}
