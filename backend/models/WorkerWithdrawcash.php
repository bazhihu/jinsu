<?php

namespace backend\models;

use Yii;
use yii\base\Exception;
use yii\web\HttpException;

/**
 * This is the model class for table "{{%worker_withdrawcash}}".
 *
 * @property integer $id
 * @property string $withdrawcash_no
 * @property integer $worker_id
 * @property string $worker_name
 * @property string $money
 * @property integer $status
 * @property string $remark_audit
 * @property string $remark_apply
 * @property integer $payee_type
 * @property integer $payee_hospital
 * @property string $payee_id_card
 * @property string $payee_bank
 * @property string $payee_bank_sub
 * @property string $payee_bank_card
 * @property string $time_apply
 * @property string $time_audit
 * @property string $time_payment
 * @property integer $admin_uid_payment
 * @property integer $admin_uid_audit
 * @property integer $admin_uid_apply
 */
class WorkerWithdrawcash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%worker_withdrawcash}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['withdrawcash_no', 'worker_id', 'worker_name', 'status', 'payee_hospital', 'payee_id_card', 'payee_bank', 'payee_bank_sub', 'payee_bank_card', 'time_apply', 'admin_uid_apply'], 'required'],
            [['worker_id', 'status', 'payee_type', 'payee_hospital', 'admin_uid_payment', 'admin_uid_audit', 'admin_uid_apply'], 'integer'],
            [['money'], 'number'],
            [['time_apply', 'time_audit', 'time_payment'], 'safe'],
            [['withdrawcash_no', 'worker_name', 'payee_id_card', 'payee_bank','payee_bank_sub', 'payee_bank_card'], 'string', 'max' => 50],
            [['remark_audit', 'remark_apply'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'withdrawcash_no' => '交易流水号',
            'worker_id' => '工号',
            'worker_name' => '姓名',
            'money' => '金额',
            'status' => '状态',
            'remark_audit' => '备注',
            'remark_apply' => '申请备注',
            'payee_type' => '收款方式',
            'payee_hospital' => '所属医院',
            'payee_id_card' => '身份证',
            'payee_bank' => '开户行',
            'payee_bank_sub' => '子账户',
            'payee_bank_card' => '银行卡',
            'time_apply' => '申请时间',
            'time_audit' => '审核时间',
            'time_payment' => '付款时间',
            'admin_uid_payment' => '付款人',
            'admin_uid_audit' => '确认人',
            'admin_uid_apply' => '申请人',
        ];
    }

    /**
     * 审核通过
     * @return array
     */
    public function agree(){
        $response = [
            'code'=>'200',
            'msg'=>''
        ];
        $this->status = 2;
        $this->time_audit = date("Y-m-d H:i:s");
        $this->admin_uid_audit = yii::$app->user->identity->getId();
        if($this->save()){
            $response['msg'] = '审核通过';
            return $response;
        }else{
            $response = [
                'code'=>'400',
                'msg'=>'审核失败'
            ];
            return $response;
        }
    }

    /**
     * 拒绝审核
     * @return array
     */
    public function refuse(){
        $response = [
            'code'=>'200',
            'msg'=>''
        ];
        $this->status = 1;
        $this->time_audit = date("Y-m-d H:i:s");
        $this->admin_uid_audit = yii::$app->user->identity->getId();
        if($this->save()){
            $response['msg'] = '拒绝成功';
            return $response;
        }else{
            $response = [
                'code'=>'400',
                'msg'=>'拒绝失败'
            ];
            return $response;
        }
    }

    /**
     * 付款
     * @return array
     */
    public function pay($id){
        $response = [
            'code'=>'200',
            'msg'=>''
        ];
        if(!$id){
            $response['code'] = 400;
            $response['msg'] = '无任何勾选';
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach($id as $key=>$val){
                if($val){
                    $pay = $this->findOne($val);
                    if($pay->status == 2){
                        $pay->status = 3;
                        $pay->time_payment = date("Y-m-d H:i:s");
                        $pay->admin_uid_payment = yii::$app->user->identity->getId();

                        if($pay->save()){
                            self::debit($pay->worker_id,$pay->money);
                        }
                    }
                }
            }
            $transaction->commit();
        }catch (Exception $e){
            $transaction->rollBack();
            throw new HttpException(400, print_r($e, true));
        }
        $response['msg'] = '付款成功';
        return $response;
    }

    /**
     * 扣款
     * @return bool
     */
    public static function debit($worker_id,$money){
        try {
            $account = WorkerAccount::findOne(['worker_id'=>$worker_id]);

            $account->balance = $account->balance - $money;
            $account->withdraw_amount = $account->withdraw_amount + $money;

            $account->save();
        }catch (Exception $e){
            throw new HttpException(400, print_r($e, true));
        }
        return true;
    }
}
