<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%wechat_log}}".
 *
 * @property string $id
 * @property integer $uid
 * @property string $body
 * @property string $total_fee
 * @property string $transaction_id
 * @property string $transaction_no
 * @property string $order_no
 * @property string $open_id
 * @property string $partner
 * @property integer $fee_type
 * @property integer $trade_mode
 * @property string $trade_state
 * @property string $time_end
 * @property string $refund_id
 * @property string $refund_no
 * @property string $refund_fee
 * @property integer $refund_channel
 * @property integer $refund_status
 * @property string $refund_time
 * @property string $spbill_create_ip
 * @property string $gmt_create
 * @property string $gmt_expire
 * @property string $attach
 * @property string $trade_type
 * @property string $goods_tag
 * @property string $nonce_str
 */
class WechatLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wechat_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'body', 'transaction_no', 'partner', 'spbill_create_ip', 'gmt_create'], 'required'],
            [['uid', 'total_fee', 'fee_type', 'trade_mode', 'refund_fee', 'refund_channel', 'refund_status'], 'integer'],
            [['time_end', 'refund_time', 'gmt_create', 'gmt_expire'], 'safe'],
            [['body'], 'string', 'max' => 200],
            [['transaction_id', 'refund_id'], 'string', 'max' => 28],
            [['transaction_no', 'trade_state', 'refund_no', 'goods_tag', 'nonce_str'], 'string', 'max' => 32],
            [['order_no', 'open_id'], 'string', 'max' => 64],
            [['partner'], 'string', 'max' => 10],
            [['spbill_create_ip'], 'string', 'max' => 20],
            [['attach'], 'string', 'max' => 188],
            [['trade_type'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'body' => 'Body',
            'total_fee' => 'Total Fee',
            'transaction_id' => 'Transaction ID',
            'transaction_no' => 'Transaction No',
            'order_no' => 'Order No',
            'open_id' => 'Open ID',
            'partner' => 'Partner',
            'fee_type' => 'Fee Type',
            'trade_mode' => 'Trade Mode',
            'trade_state' => 'Trade State',
            'time_end' => 'Time End',
            'refund_id' => 'Refund ID',
            'refund_no' => 'Refund No',
            'refund_fee' => 'Refund Fee',
            'refund_channel' => 'Refund Channel',
            'refund_status' => 'Refund Status',
            'refund_time' => 'Refund Time',
            'spbill_create_ip' => 'Spbill Create Ip',
            'gmt_create' => 'Gmt Create',
            'gmt_expire' => 'Gmt Expire',
            'attach' => 'Attach',
            'trade_type' => 'Trade Type',
            'goods_tag' => 'Goods Tag',
            'nonce_str' => 'Nonce Str',
        ];
    }
}
