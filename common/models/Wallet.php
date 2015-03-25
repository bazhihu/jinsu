<?php

namespace common\models;

use backend\models\WalletUser;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%wallet_user_detail}}".
 *
 * @property integer $detail_id 交易流水ID
 * @property string $detail_id_no 交易流水编号
 * @property integer $order_id 订单ID
 * @property string $order_no 订单编号
 * @property integer $worker_id 护工ID
 * @property integer $uid 用户ID
 * @property string $detail_money 交易金额
 * @property integer $detail_type 交易类型,1消费,2充值,3提现
 * @property string $wallet_money 当前账户余额
 * @property string $detail_time 交易时间
 * @property string $remark 备注
 * @property string $pay_from 支付渠道
 * @property string $extract_to 提现渠道
 * @property integer $admin_uid 管理员ID
 */
class Wallet extends \yii\db\ActiveRecord
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

    /**
     * @desc 用户充值
     * @uid
     * @pay_from 支付渠道
     * @return bool
     */
    public function  recharge($uid,$pay_from = self::WALLET_PAY_FROM_BACKSTAGE)
    {
        #充值金额
        $money = $this->detail_money;
        #用户余额
        $walletUser = $this->getUserWallet($uid);

        $param['wallet_user_detail']['detail_id_no']    = self::_generateDetailNo($uid); //'交易流水编号',
        $param['wallet_user_detail']['uid']             = $uid; //'用户ID',
        $param['wallet_user_detail']['detail_type']     = self::WALLET_TYPE_RECHARGE; //'交易类型',
        $param['wallet_user_detail']['wallet_money']    = $walletUser['money']+$money; //'账户余额',
        $param['wallet_user_detail']['detail_time']     = date('Y-m-d H:i:s'); //'交易时间',
        $param['wallet_user_detail']['pay_from']        = self::WALLET_PAY_FROM_BACKSTAGE; //'支付渠道',
        $param['wallet_user_detail']['admin_uid']       = Yii::$app->user->identity->getId(); //'管理员ID',

        $param['wallet_user']['uid']                    = $uid;
        $param['wallet_user']['money']                  = $param['wallet_user_detail']['wallet_money'];
        $param['wallet_user']['money_pay']              = $walletUser['money_pay']+$money;

        $this->setAttributes($param['wallet_user_detail'], false);
        if(!$this->save())
        {
            throw new HttpException(400, print_r($this->getErrors(), true));
        }

        if($this->saveWalletUser($param['wallet_user']))
            return true;
    }

    /**
     * @desc 获取用户的钱包信息
     * @param $uid
     * @return array 返回用户信息
     */
    public function getUserWallet($uid){
        $walletUser = WalletUser::findOne(['uid'=>$uid]);
        #用户账户余额
        $param = array();
        if($walletUser)
        {
            $param = ArrayHelper::toArray($walletUser);
            return $param;
        }else{
            $walletUser = new WalletUser();
            $walletUser->setAttribute('uid',$uid);
            if($walletUser->save()){
                $param['uid'] = $uid;
                $param['money'] = '0';
                $param['money_pay'] = '0';
                $param['money_pay_s'] = '0';
                $param['money_consumption'] = '0';
                $param['money_extract'] = '0';
                return $param;
            }
        }
    }

    /**
     * @desc 保存用户钱包信息
     * @param $params
     * @return bool
     * @throws HttpException
     */
    public function saveWalletUser($params){
        $walletUser = new WalletUser();
        $walletUser->setAttributes($params,false);
        if($walletUser->updateAll($params,$params['uid'])){
            return true;
        }else{
            throw new HttpException(400, print_r($walletUser->getErrors(), true));
        }
    }

    /**
     * @desc 生成交易流水编号
     * @param $uid
     * @return string
     */
    private function _generateDetailNo($uid){
        return date("YmdHis").$uid.str_pad(rand(0, 999), 3, 0, STR_PAD_LEFT);
    }
}
