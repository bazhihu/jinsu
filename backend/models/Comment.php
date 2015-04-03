<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $comment_id
 * @property string $order_no
 * @property string $uid
 * @property string $worker_id
 * @property integer $star
 * @property string $content
 * @property integer $status
 * @property string $comment_date
 * @property string $audit_date
 * @property string $adder
 * @property string $auditer
 * @property string $type
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public  $comment_date_begin;
    public  $comment_date_end;

    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'worker_id', 'star', 'status', 'adder','editer', 'auditer'], 'integer'],
            [['content'], 'required'],
            [['comment_date','edit_date', 'audit_date'], 'safe'],
            ['worker_name', 'string', 'max' => 20],
            ['content', 'string'],
            [['order_no','comment_ip'], 'string', 'max' =>50],
            [['type'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_no' => '订单号',
            'uid' => '用户名',
            'worker_id' => '护工编号',
            'worker_name' => '护工姓名',
            'star' => '星级',
            'content' => '评价内容',
            'status' => '状态',
            'comment_date' => '评论时间',
            'edit_date' => '编辑时间',
            'comment_date_begin' => '时间范围',
            'comment_date_end' => '至',
            'audit_date' => '审核时间',
            'adder' => '添加人',
            'editer' => '编辑人',
            'auditer' => '审核人',
            'comment_ip' => '评论IP',
            'type' => '来源',
        ];
    }

//    public function  commentAudit(){
//        $comment_ids = $_POST['comment_id'];
//        self::model()->updateAll(array('status'=>2,'auditer'=>1,'audit_date'=>date('Y-m-d H:i:s')), 'password=:pass',array(':pass'=>'1111a1'));
//        if($count>0){
//            echo "修改成功";
//        }else{
//            echo "修改失败";
//        }
//
//    }
}
