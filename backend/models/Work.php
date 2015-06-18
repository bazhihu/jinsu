<?php

namespace backend\Models;

use Yii;

/**
 * This is the model class for table "yayh_work".
 *
 * @property string $work_id
 * @property string $worker_id
 * @property string $worker_name
 * @property string $content
 * @property string $from_where
 * @property string $mobile
 * @property string $user_name
 * @property string $add_date
 * @property integer $adder
 * @property string $solve_date
 * @property integer $solver
 * @property string $solver_content
 * @property integer $status
 */
class Work extends \yii\db\ActiveRecord
{
    public  $add_date_begin,$add_date_end;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yayh_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id','worker_id', 'adder', 'solver', 'status','type'], 'integer'],
            [['order_no','content', 'solver_content'], 'string'],
            [['work_no','add_date', 'solve_date','add_date_begin','add_date_end'], 'safe'],
            [['worker_name', 'user_name'], 'string', 'max' => 20],
            [['from_where'], 'string', 'max' => 10],
            [['mobile'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'work_no' => '工单编号',
            'order_no' => '订单编号',
            'worker_id' => '员工号',
            'worker_name' => '员工姓名',
            'content' => '内容',
            'from_where' => '渠道',
            'mobile' => '联系电话',
            'user_name' => '联系人姓名',
            'add_date' => '时间',
            'adder' => '添加人',
            'solve_date' => '解决时间',
            'solver' => '解决人',
            'solver_content' => '解决方法',
            'status' => '状态',
            'add_date_begin'=>'时间',
            'add_date_end'=>'至',
            'type'=>'类型'
        ];
    }
}
