<?php

namespace common\models;

use backend\models\User;
use backend\models\WalletDebitRecords;
use backend\models\WalletIncrement;
use backend\models\WalletRechargeRecords;
use backend\models\WalletRefundRecords;
use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use backend\models\WalletUser;
use backend\models\WalletUserDetail;
use yii\web\HttpException;

/**
 * @author zhiqiang
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
class Wallet
{
    /**
     * 用户充值
     * @param $param
     * [
     *      'uid'           =>'', //用户ID
     *      'pay_from'      =>'', //支付渠道
     *      'money'  =>'', //充值金额
     * ]
     * @return bool
     * @throws HttpException
     * @throws \yii\db\Exception
     */
    public function recharge($params)
    {
        #事务-START
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            #更新wallet-user 表
            $walletUser = self::addMoney($params['uid'], $params['money']);

            $detail = array();//添加消费记录
            $detail['uid']          = $walletUser->uid;
            $detail['mobile']       = User::findOne(['id'=>$walletUser->uid])->mobile;
            $detail['detail_money'] = $params['money'];
            $detail['wallet_money'] = $walletUser->money;
            $detail['pay_from']     = $params['pay_from'];
            $detail['admin_uid']    = Yii::$app->user->identity->getId();

            $result = self::rechargeRecords($detail);
            if ($result['code'] !== '200') {
                throw new HttpException(400, "", true);
            }
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            throw new HttpException(400, print_r($e, true));
        }
        #事务-END
        return true;
    }

    /**
     * 充值记录入库
     * @param $params
     * [
     *      'trade_no'          =>充值记录编号
     *       'uid'              =>用户ID
     *       'mobile'           =>手机号
     *        'detail_money'    =>充值金额
     *       'wallet_money'     =>余额
     *       'admin_uid'        =>操作者ID
     *       'pay_from'         =>支付渠道
     * ]
     * @return array
     * @throws HttpException
     */
    public static function rechargeRecords($params)
    {
        $response = [
            'code' => '200',
            'msg' => ''
        ];
        $rechargeRecords = new WalletRechargeRecords();
        $records = [
            'trade_no'      => self::_generateWalletNo(),
            'uid'           => $params['uid'],
            'mobile'        => $params['mobile'],
            'money'         => $params['detail_money'],
            'balance'       => $params['wallet_money'],
            'admin_uid'     => $params['admin_uid'],
            'time'          => date('Y-m-d H:i:s'),
            'pay_from'      => $params['pay_from'],
        ];

        $rechargeRecords->setAttributes($records);
        if(!$rechargeRecords->save()){
            throw new HttpException(400, print_r($rechargeRecords->getErrors(), true));
        }
        $response['msg'] = '记录成功';
        return $response;
    }

    /**
     * 加钱
     * @param int $uid 用户ID
     * @param number $money 钱
     * @return WalletUser|Wallet|null
     * @throws HttpException
     */
    public static function addMoney($uid, $money){
        #获取所需的账户信息
        $walletUser = self::checkAccount($uid);

        $user = array();//用户钱包表所需字段
        $user['money']      = $walletUser->money + $money;//账户余额
        $user['money_pay']  = $walletUser->money_pay + $money;//账户累积充值金额

        if($money<0){
            $user['money_pay_s'] = $walletUser->money_pay_s - $money;//累积充值负金额
        }
        $walletUser->attributes = $user;

        if(!$walletUser->save())
        {
            throw new HttpException(400, print_r($walletUser->getErrors(), true));
        }
        return $walletUser;
    }

    /**
     * 退款
     * @param $uid
     * @param $money
     * @return null|static
     * @throws HttpException
     */
    public static function refundMoney($uid, $money){
        $wallet = WalletUser::findOne(['uid'=>$uid]);
        if(empty($wallet)){
            throw new NotFoundHttpException('The requested user wallet does not exist.');
        }

        $wallet->money = $wallet->money + $money;
        if(!$wallet->save()){
            throw new HttpException(400, print_r($wallet->getErrors(), true));
        }
        return $wallet;
    }
    /**
     * 查询用户账户信息
     * @param $uid 用户ID
     * @return WalletUser|null|static
     * @throws HttpException
     */
    public static function checkAccount($uid){

        $walletUser = WalletUser::findOne(['uid'=>$uid]);

        if(empty($walletUser)){
            $walletUser = new WalletUser();
            $wallet['uid'] = $uid;
            $walletUser->attributes = $wallet;
            if(!$walletUser->save()){
                throw new HttpException(400, print_r($walletUser->getErrors(), true));
            }
        }
        return $walletUser;
    }

    /**
     * 扣款入库
     * @author HZQ
     * @param $params
     * [
     *      'order_id'      int  订单ID                           必填
     *      'order_no'   string  订单编号                           必填
     *      'uid'           int  用户id                           必填
     *      'detail_money'  int  交易金额                          必填
     *      'wallet_money'  int  当前账户余额                       必填
     *      'remark'        varchar 备注
     *      'admin_uid'     int  管理员ID
     * ]
     * @return array
     * @throws HttpException
     */
    public static function addConRecords($params){
        $response = [
            'code' => '200',
            'msg' => ''
        ];
        $walletDebitRecords = new WalletDebitRecords();
        $debit = [
            'trade_no'      => self::_generateWalletNo(),
            'order_id'      => $params['order_id'],
            'order_no'      => $params['order_no'],
            'uid'           => $params['uid'],
            'mobile'        => User::findOne(['uid'=>$params['uid']])->mobile,
            'money'         => $params['detail_money'],
            'balance'       => $params['wallet_money'],//当前账户余额
            'time'          => date('Y-m-d H:i:s'),
            'admin_uid'     => $params['admin_uid']?$params['admin_uid']:"",
            'remark'        => $params['remark']?$params['remark']:"",
        ];
        $walletDebitRecords->setAttributes($debit);
        if(!$walletDebitRecords->save()){
            throw new HttpException(400, print_r($walletDebitRecords->getErrors(), true));
        }
        $response['msg'] = '记录成功';
        return $response;
    }

    /**
     * 退款记录入库
     * @param $params
     * [
     *      'order_id'          订单ID
     *      'order_no'          订单编号
     *      'uid'               用户ID
     *      'detail_money'      交易金额
     *      'wallet_money'      余额
     *      'admin_uid'         操作者ID
     *      'remark'            备注
     * ]
     * @return array
     * @throws HttpException
     */
    public static function refundRecords($params){
        $response = [
            'code' => '200',
            'msg' => ''
        ];
        $walletRefundRecords = new WalletRefundRecords();
        $refundRecords = [
            'trade_no'      =>self::_generateWalletNo(),
            'order_id'      =>$params['order_id'],
            'order_no'      =>$params['order_no'],
            'uid'           =>$params['uid'],
            'mobile'        =>User::findOne(['uid'=>$params['uid']])->mobile,
            'money'         =>$params['detail_money'],
            'balance'       =>$params['wallet_money'],
            'time'          =>date('Y-m-d H:i:s'),
            'admin_uid'     =>$params['admin_uid']?$params['admin_uid']:"",
            'remark'        =>$params['remark']?$params['remark']:"",
        ];
        $walletRefundRecords->setAttributes($refundRecords);
        if(!$walletRefundRecords->save()){
            throw new HttpException(400, print_r($walletRefundRecords->getErrors(), true));
        }
        $response['msg'] = '记录成功';
        return $response;
    }
    /**
     * 扣款
     * @param int $uid 用户
     * @param number $amount 金额
     * @return array
     * @author zhangbo
     */
    public static function deduction($uid, $amount){
        $response = [
            'code' => '200',
            'msg' => ''
        ];
        //判断金额是否足够
        $wallet = WalletUser::findOne($uid);
        $money = empty($wallet->money) ? 0 : $wallet->money;

        $response['money'] = $money;
        if($amount > $money){
            $response['code'] = '412';
            $response['msg'] = '余额不足,当前余额：'.$money;
            return $response;
        }

        $wallet->money = $wallet->money-$amount;
        $wallet->money_consumption = $wallet->money_consumption+$amount;
        if(!$wallet->save()){
            $response['code'] = '412';
            $response['msg'] = '扣款失败：'.print_r($wallet->getErrors(), true);
            return $response;
        }

        $response['msg'] = '扣款成功';
        return $response;
    }
    /**
     * 生成钱包流水号
     * @return string
     * @throws \Exception
     * @author HZQ
     */
    private static function _generateWalletNo(){
        $walletIncrement = new WalletIncrement();
        $walletIncrement->insert();
        return date("Ymd").$walletIncrement->id.str_pad(rand(0, 999), 3, 0, STR_PAD_LEFT);
    }
}