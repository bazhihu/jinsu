<?php

namespace backend\models;

use api\modules\v2\models\Worker;
use Yii;
use yii\web\HttpException;
use yii\base\Exception;

/**
 * This is the model class for table "{{%worker_leave}}".
 *
 * @property string $id
 * @property string $worker_id
 * @property string $worker_name
 * @property string $start_time
 * @property string $end_time
 * @property string $real_end
 * @property string $leave_cause
 * @property integer $status
 */
class WorkerLeave extends \yii\db\ActiveRecord
{
    public static $_Leave = 'leave_';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%worker_leave}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id', 'worker_name', 'start_time', 'end_time', 'leave_cause'], 'required'],
            [['worker_id', 'status'], 'integer'],
            [['start_time', 'end_time', 'real_end'], 'safe'],
            [['worker_name', 'leave_cause'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'worker_id' => '工号',
            'worker_name' => '姓名',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'real_end' => '实际结束时间',
            'leave_cause' => '请假原因',
            'status' => '状态',
        ];
    }

    /**
     * 创建请假信息
     * @return bool
     */
    public function create(){
        if(!$this->save()){
            return false;
        }
        $schedule = new WorkerSchedule();
        $params = [
            'order_no'=>self::getScheduleId($this->id),
            'type'=>WorkerSchedule::LEAVE,
            'worker_id'=>$this->worker_id,
            'start_date'=>$this->start_time,
            'end_date'=>$this->end_time,
        ];
        $schedule->setAttributes($params,false);
        if(!$schedule->save()){
            return false;
        }
        return true;
    }

    /**
     * 获取工单编号
     * @param $id
     * @return string
     */
    public static function getScheduleId($id){
        return self::$_Leave.$id;
    }
    /**
     * 结束请假
     * @param $endTime
     * @return array
     */
    public function end($endTime){
        $response = [
            'code'=>'200',
            'msg'=>'',
        ];
        if($endTime){
            $this->real_end = $endTime;
            $this->status = 10;
            if($this->save()){
                try {
                    $schedule = WorkerSchedule::findOne(['order_no'=>self::getScheduleId($this->id),'type'=>WorkerSchedule::LEAVE]);
                    #删除请假工单
                    $schedule->delete();
                }catch (Exception $e){
                    throw new HttpException(400, print_r($e, true));
                }
                $response['msg'] = '结束成功';
                return $response;
            }else{
                $response['code'] = 400;
                $response['msg'] = '请求失败';
                return $response;
            }
        }
    }
}
