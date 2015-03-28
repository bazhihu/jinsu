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
class WalletUserDetail extends \yii\db\ActiveRecord
{
    public $mobile;//电话号码
    public $fromDate;
    public $toDate;

    #明细类型
    const WALLET_TYPE_CONSUME = 1; //消费
    const WALLET_TYPE_RECHARGE = 2; //充值
    const WALLET_TYPE_WITHDRAWALS = 3; //提现

    #支付渠道
    const PAY_FROM_BACKEND = 'backend'; //后台
    const PAY_FROM_APP = 'app'; //手机应用


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

            [['detail_no','order_id','order_no','uid','detail_money','detail_type','wallet_money','detail_time','pay_from'],'required','on'=>'consume'],

            [['order_id', 'worker_id', 'uid', 'detail_type', 'admin_uid'], 'integer'],
            [['wallet_money'], 'number'],
            // [['detail_time'], 'safe'],
            [['detail_no', 'order_no', 'pay_from', 'extract_to'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255]
        ];
    }
    public function scenarios()
    {
        return[
            'pay_create'=>['detail_money'],
            'consume'=>['detail_no','order_id','order_no','uid','detail_money','detail_type','wallet_money','detail_time','pay_from']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'detail_id' => '交易流水ID',
            'detail_no' => '交易流水',
            'order_id' => '订单ID',
            'order_no' => '订单编号',
            'worker_id' => '护工ID',
            'uid' => '用户帐号',
            'detail_money' => '充值金额(元)',
            'detail_type' => '交易类型',
            'wallet_money' => '账户余额',
            'detail_time' => '交易时间',
            'remark' => '备注',
            'pay_from' => '支付渠道',
            'extract_to' => '提现渠道',
            'admin_uid' => '经办人',
        ];
    }
    public function recharge($uid)
    {
        $param = array();
        #正充值
        $param['top'] = 0;
        if($this->detail_money<0){
            $param['top'] = 1;
        }

        $param['detail_money']  = abs($this->detail_money);
        $param['pay_from']      = 1;
        $param['uid']           = $uid;

        $wallet = new Wallet();
        if($wallet->recharge($param))
        {
            return true;
        }
        return false;
    }
}
