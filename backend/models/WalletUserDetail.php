<?php

namespace backend\models;

use Yii;
use common\models\Wallet;

/**
 * This is the model class for table "{{%wallet_user_detail}}".
 *
 * @property integer $detail_id
 * @property string $detail_id_no
 * @property integer $order_id
 * @property string $order_no
 * @property integer $worker_id
 * @property integer $uid
 * @property string $detail_money
 * @property integer $detail_type
 * @property string $wallet_money
 * @property string $detail_time
 * @property string $remark
 * @property string $pay_from
 * @property string $extract_to
 * @property integer $admin_uid
 */
class WalletUserDetail extends Wallet
{
    public $mobile;//电话号码

    #明细类型
    const WALLET_TYPE_CONSUME = 1; //消费
    const WALLET_TYPE_RECHARGE = 2; //充值
    const WALLET_TYPE_WITHDRAWALS = 3; //提现

    #支付渠道
    const WALLET_PAY_FROM_BACKSTAGE = 'Backstage';//后台
    const WALLET_PAY_FROM_APP = 'App';//app

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_user_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['detail_money','required','on'=>'pay_create'],
            ['detail_money','number','on'=>'pay_create'],

            [['order_id', 'worker_id', 'uid', 'detail_type', 'admin_uid'], 'integer'],
            [['wallet_money'], 'number'],
            // [['detail_time'], 'safe'],
            [['detail_id_no', 'order_no', 'pay_from', 'extract_to'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255]
        ];
    }
    public function scenarios()
    {
        return[
            'pay_create'=>['detail_money'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'detail_id' => '交易流水ID',
            'detail_id_no' => '交易流水编号',
            'order_id' => '订单ID',
            'order_no' => '订单编号',
            'worker_id' => '护工ID',
            'uid' => '用户ID',
            'detail_money' => '交易金额',
            'detail_type' => '交易类型',
            'wallet_money' => '账户余额',
            'detail_time' => '交易时间',
            'remark' => '备注',
            'pay_from' => '支付渠道',
            'extract_to' => '提现渠道',
            'admin_uid' => '管理员ID',
        ];
    }
}
