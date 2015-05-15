<?php

namespace backend\models;

use Yii;
use common\models\Wallet;
use yii\helpers\ArrayHelper;

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
    public $fromDate;
    public $toDate;

    #明细类型
    const WALLET_TYPE_CONSUME = 1; //消费
    const WALLET_TYPE_RECHARGE = 2; //充值
    const WALLET_TYPE_WITHDRAWALS = 3; //提现
    const WALLET_TYPE_REFUND = 4; //退款

    #支付渠道
    //const PAY_FROM_BACKEND = 'backend'; //后台现金
    const PAY_FROM_CASH = 'cash'; //现金
    const PAY_FROM_CARD = 'card'; //刷卡
    const PAY_FROM_CHEQUE = 'cheque'; //支票
    const PAY_FROM_REMIT = 'remit'; //汇款
    const PAY_FROM_ALIPAY = 'alipay'; //Alipay(支付宝)
    const PAY_FROM_WECHAT = 'wechat'; //Wechat(微信)

    #提现渠道
    const WITHDRAW_CHANNELS_BACKEND = 'backend'; //后台现金
    const WITHDRAW_CHANNELS_ALIPAY = 'alipay'; //Alipay(支付宝)
    const WITHDRAW_CHANNELS_WECHAT = 'wechat'; //Wechat(微信)

    public static $payFromLabels = [
        self::PAY_FROM_CASH => '现金',
        self::PAY_FROM_CARD => '刷卡',
        self::PAY_FROM_CHEQUE => '支票',
        self::PAY_FROM_REMIT => '汇款',
        self::PAY_FROM_ALIPAY => '支付宝',
        self::PAY_FROM_WECHAT => '微信'
    ];
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
            //[['pay_from'],'required'],
            //[['detail_money','uid'],'required','on'=>'pay_create'],

            //[['detail_no','uid','detail_money','detail_type','wallet_money','detail_time'],'required','on'=>'consume'],

            [['uid', 'detail_money', 'detail_type', 'wallet_money' ,'mobile'],'required'],
            [['detail_money', 'uid' ,'wallet_money'],'number'],

            [['order_id', 'worker_id', 'uid', 'detail_type', 'admin_uid'], 'integer'],
            [['detail_time'], 'safe'],
            [['detail_no', 'order_no', 'pay_from', 'extract_to'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * 定义场景
     * @return array
     */
    /*public function scenarios()
    {
        return[
            'pay_create'=>['detail_money','uid'],
            'consume'=>['detail_no','order_id','order_no','uid','detail_money','detail_type','wallet_money','detail_time','pay_from','extract_to','remark','admin_uid']
        ];
    }*/
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
            'mobile' => '用户帐号',
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

    /**
     * 充值
     * @return bool
     * @throws \yii\web\HttpException
     */
    public function recharge()
    {
        $params = array();
        $params['detail_money']  = $this->detail_money;
        $params['pay_from']      = self::PAY_FROM_BACKEND;
        $params['uid']           = $this->uid;

        $wallet = new Wallet();
        if($wallet->recharge($params))
        {
            return true;
        }
        return false;
    }

    /**
     * 获取所有是内勤人员的角色
     * @return static[]
     */
    public static function getInternalRoles(){
        $result = AdminUser::findAll(['staff_role' => '内勤人员']);
        return ArrayHelper::map($result, 'admin_uid', 'staff_name');
    }
}
