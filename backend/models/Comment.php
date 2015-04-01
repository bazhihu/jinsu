<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $comment_id
 * @property string $order_id
 * @property string $uid
 * @property string $worker_id
 * @property integer $star
 * @property string $content
 * @property integer $status
 * @property string $comment_date
 * @property string $audit_time
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
            [['order_id', 'uid', 'worker_id', 'star', 'status', 'adder', 'auditer'], 'integer'],
            [['content'], 'required'],
            [['comment_date', 'audit_time'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => '订单号',
            'uid' => '用户ID',
            'worker_id' => '护工编号',
            'worker_name' => '护工姓名',
            'star' => '星级',
            'content' => '评价内容',
            'status' => '状态',
            'comment_date' => '评论时间',
            'comment_date_begin' => '时间范围',
            'comment_date_end' => '至',
            'audit_time' => '审核时间',
            'adder' => '添加人',
            'auditer' => '审核人',
            'type' => '来源',
        ];
    }
}
