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
            'content' => '评论内容',
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

    static public function  commentAudit($comment_ids,$op='audit_yes'){
        $connection = Yii::$app->db;
        $auditer = yii::$app->user->getId();
        if($op=='audit_yes'){
            $status = 2;
        }else{
            $status = 3;
        }

        //更新评论状态
        $sql = "update yayh_comment set status = ".$status.",auditer=".$auditer.",audit_date='".date('Y-m-d H:i:s')."' where comment_id in ($comment_ids)";
        $command = $connection->createCommand($sql);
        $command->query();


        //评论数
        $worker_sql = "select DISTINCT worker_id from yayh_comment where comment_id in ($comment_ids)";
        $worker_command = $connection->createCommand($worker_sql);
        $worker_result = $worker_command->query();
        if($worker_result){
            foreach($worker_result as $row){
                //查询护工评论数
                $comment_sql = "select count(*) as num, avg(star) as avg_star,count(star)  as star_num from yayh_comment where worker_id=".$row['worker_id']." and status=2";
                //echo $comment_sql;die();
                $comment_command = $connection->createCommand($comment_sql);
                $comment_row= $comment_command->queryOne();

                $comment_num = 0;
                $avg_star = 0;
                $good_star_num=0;
                $star_num=0;

                $comment_num = $comment_row['num']? $comment_row['num']:0;
                $avg_star = $comment_row['avg_star']?$comment_row['avg_star']:0;
                $star_num = $comment_row['star_num']?$comment_row['star_num']:0;

                //查询好评率
                $good_sql = "select count(star)  as sum_star from yayh_comment where worker_id=".$row['worker_id']." and star>=4 and status=2";
                $good_command = $connection->createCommand($good_sql);
                $good_star_num= $good_command->queryColumn()[0];
                $good_rate = $star_num ? ceil($good_star_num/$star_num)*100:"";

                //更新护工评论总数
                $update_sql = "update yayh_worker  set total_comment=".$comment_num." ,star = ".$avg_star.",good_rate=".$good_rate." where worker_id=".$row['worker_id'];
                $update_command = $connection->createCommand($update_sql);
                $update_command->query();
            }
        }
     }
}