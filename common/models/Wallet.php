<?php

namespace common\models;

use backend\models\WalletIncrement;
use Yii;
use yii\base\Exception;
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
     *      'pay_from'      =>'', //支付渠道 1 backstage(后台)|2 other
     *      'top'           =>'', //充值类型 0为正充值|1为负充值
     *      'detail_money'  =>'', //充值金额
     * ]
     * @return bool
     * @throws HttpException
     * @throws \yii\db\Exception
     */
    public function recharge($param)
    {
        $walletUser = WalletUser::findOne(['uid'=>$param['uid']]);
        if(empty($walletUser)){
            $walletUser = new WalletUser();
            $wallet['uid'] = $param['uid'];

            $walletUser->attributes = $wallet;
            if(!$walletUser->save()){
                throw new HttpException(400, print_r($walletUser->getErrors(), true));
            }
        }
        $walletDetail = $param['wallet_user_detail'];
        $walletDetail['detail_no']    = self::_generateWalletNo(); //'交易流水编号',
        $walletDetail['uid']          = $param['uid']; //'用户ID',
        $walletDetail['detail_type']  = WalletUserDetail::WALLET_TYPE_RECHARGE; //'交易类型',
        $walletDetail['detail_money'] = $param['detail_money']; //'交易金额',
        $walletDetail['detail_time']  = date('Y-m-d H:i:s'); //'交易时间',
        $walletDetail['pay_from']     = $param['pay_from']; //'支付渠道',
        $walletDetail['admin_uid']    = Yii::$app->user->identity->getId(); //'管理员ID',

        $walletData = $param['wallet_user'];

        #判断充值正负
        if(!$param['top']){
            $walletDetail['wallet_money'] = $walletUser['money']+$param['detail_money']; //'账户余额',
            $walletData['money_pay'] = $walletUser['money_pay']+$param['detail_money'];
        }else{
            $walletDetail['wallet_money'] = $walletUser['money']-$param['detail_money']; //'账户余额',
            $walletData['money_pay'] = $walletUser['money_pay']-$param['detail_money'];
            $walletData['money_pay_s'] = $walletUser['money_pay_s']+$param['detail_money'];//累积充值负金额

            if($walletData['money_pay']<0){
                throw new HttpException(400, print_r(("充值错误!"), true));
            }
        }
        $walletData['uid'] = $param['uid'];
        $walletData['money'] = $walletDetail['wallet_money'];

        #事务-START
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $walletUserDetail = new WalletUserDetail(['scenario' => 'pay_create']);
            $walletUserDetail->setAttributes($walletDetail,false);
            if (!$walletUserDetail->save()) {
                throw new HttpException(400, print_r($walletUserDetail->getErrors(), true));
            }

            $walletUser->attributes = $walletData;
            if (!$walletUser->save()) {
                throw new HttpException(400, print_r($walletUser->getErrors(), true));
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
     * 扣款
     * @param int $uid 用户
     * @param number $amount 金额
     * @return array
     * @author zhangbo
     */
    public function deduction($uid, $amount){
        $response = [
            'code' => '200',
            'msg' => ''
        ];
        //判断金额是否足够
        $wallet = WalletUser::findOne($uid);
        if(empty($wallet->money)){
            $money = 0;
        }else{
            $money = $wallet->money;
        }

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
     * 消费记录
     * @author HZQ
     * @param $params
     * [
     *      'order_id'      int  订单ID
     *      'order_no'   string  订单编号
     *      'uid'           int  用户id
     *      'detail_money'  int  交易金额
     *      'wallet_money'  int  当前账户余额
     *      'detail_type'   int  交易类型 默认 1 (1消费,2充值,3提现)
     *      'pay_from'      int  支付渠道 默认 1 (1后台,2 app)
     * ]
     * @return array
     */
    public function addConRecords($params){
        $response = [
            'code' => '200',
            'msg' => ''
        ];
        $walletUserDetail = new WalletUserDetail(['scenario' => 'consume']);
        $userDetail = [
            'detail_no'  => self::_generateWalletNo(),
            'order_id'      => $params['order_id'],
            'order_no'      => $params['order_no'],
            'uid'           => $params['uid'],
            'detail_money'  => $params['detail_money'],
            'detail_type'   => $params['detail_type'],//默认为1
            'wallet_money'  => $params['wallet_money'],//当前账户余额
            'detail_time'   => date('Y-m-d H:i:s'),
            'pay_from'      => $params['pay_from'],//后台为 1
        ];
        $walletUserDetail->setAttributes($userDetail);
        if(!$walletUserDetail->save())
        {
            $response['code'] = '412';
            $response['msg'] = '记录失败'.print_r($walletUserDetail->getErrors(), true);
            return $response;
        }
        $response['msg'] = '记录成功';
        return $response;
    }
    /**
     * 生成钱包流水号
     * @return string
     * @throws \Exception
     * @author HZQ
     */
    private function _generateWalletNo(){
        $walletIncrement = new WalletIncrement();
        $walletIncrement->insert();
        return date("Ymd").$walletIncrement->id.str_pad(rand(0, 999), 3, 0, STR_PAD_LEFT);
    }
}
