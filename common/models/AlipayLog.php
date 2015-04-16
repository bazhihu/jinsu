<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%alipay_log}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $subject
 * @property string $total_fee
 * @property string $order_no
 * @property string $trade_no
 * @property string $seller_id
 * @property string $seller_email
 * @property string $seller_account_name
 * @property string $buyer_id
 * @property string $buyer_email
 * @property string $buyer_account_name
 * @property string $body
 * @property string $notify_type
 * @property string $notify_time
 * @property string $refund_batch_no
 * @property integer $refund_batch_num
 * @property string $refund_batch_detail_data
 * @property integer $refund_success_num
 * @property string $refund_result_details
 * @property string $gmt_create
 * @property string $gmt_payment
 * @property string $gmt_close
 * @property string $gmt_refund
 * @property string $trade_status
 * @property string $refund_status
 * @property string $visit_ip
 */
class AlipayLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%alipay_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'subject', 'transaction_no', 'seller_email', 'gmt_create', 'visit_ip'], 'required'],
            [['uid', 'refund_batch_num', 'refund_success_num'], 'integer'],
            [['total_fee'], 'number'],
            [['notify_time', 'gmt_create', 'gmt_payment', 'gmt_close', 'gmt_refund'], 'safe'],
            [['refund_batch_detail_data', 'refund_result_details'], 'string'],
            [['subject'], 'string', 'max' => 256],
            [['order_no', 'notify_type'], 'string', 'max' => 50],
            [['trade_no'], 'string', 'max' => 64],
            [['buyer_id', 'refund_status'], 'string', 'max' => 30],
            [['seller_email', 'seller_account_name', 'buyer_email', 'buyer_account_name'], 'string', 'max' => 100],
            [['body'], 'string', 'max' => 400],
            [['refund_batch_no'], 'string', 'max' => 32],
            [['trade_status', 'visit_ip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户ID',
            'subject' => '商品名称',
            'total_fee' => '交易金额',
            'order_no' => '订单编号',
            'trade_no' => '支付宝交易号',
            'seller_email' => '卖家支付宝账号',
            'buyer_id' => '买家支付宝账户号',
            'buyer_email' => '买家支付宝账号',
            'buyer_account_name' => '买家别名支付宝账号',
            'body' => '商品描述',
            'notify_type' => '通知类型',
            'notify_time' => '通知时间',
            'refund_batch_no' => '退款批次号(格式为:退款日期(8 位) +流水号(3~24 位))',
            'refund_batch_num' => '退款总笔数',
            'refund_batch_detail_data' => '单笔数据集(退款请求的明细数据)',
            'refund_success_num' => '退款成功 总数',
            'refund_result_details' => '退款结果明细',
            'gmt_create' => '交易创建时间',
            'gmt_payment' => '交易付款时间',
            'gmt_close' => '交易关闭时间',
            'gmt_refund' => '退款时间',
            'trade_status' => '交易状态',
            'refund_status' => '退款状态',
            'visit_ip' => '访问者IP',
        ];
    }
}
