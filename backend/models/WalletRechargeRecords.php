<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%wallet_recharge_records}}".
 *
 * @property string $id
 * @property string $trade_no
 * @property integer $uid
 * @property string $mobile
 * @property string $money
 * @property string $balance
 * @property integer $admin_uid
 * @property string $time
 * @property string $pay_from
 * @property string $remark
 */
class WalletRechargeRecords extends \yii\db\ActiveRecord
{

    #支付渠道
    const PAY_FROM_BACKEND = 'backend'; //后台现金
    const PAY_FROM_ALIPAY = 'alipay'; //Alipay(支付宝)
    const PAY_FROM_WECHAT = 'wechat'; //Wechat(微信)

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_recharge_records}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trade_no', 'uid', 'mobile', 'money', 'balance', 'admin_uid', 'time', 'pay_from'], 'required'],
            [['uid', 'admin_uid'], 'integer'],
            [['money', 'balance'], 'number'],
            [['time'], 'safe'],
            [['trade_no', 'mobile', 'pay_from', 'remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '交易流水ID',
            'trade_no' => '交易流水',
            'uid' => '用户帐号',
            'mobile' => '用户帐号',
            'money' => '充值金额(元)',
            'balance' => '账户余额',
            'admin_uid' => '经办人',
            'time' => '交易时间',
            'pay_from' => '支付渠道',
            'remark' => '备注',
        ];
    }
}
