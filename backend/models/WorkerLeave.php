<?php

namespace backend\models;

use Yii;

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
    public function create(){
        return false;
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
