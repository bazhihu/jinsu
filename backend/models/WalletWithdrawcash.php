<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%wallet_withdrawcash}}".
 *
 * @property integer $withdrawcash_id
 * @property string $withdrawcash_no
 * @property integer $uid
 * @property string $money
 * @property integer $status
 * @property string $remark_audit
 * @property string $remark_apply
 * @property integer $payee_type
 * @property string $payee_time
 * @property string $payee_hospital
 * @property string $payee_name
 * @property string $payee_id_card
 * @property string $time_apply
 * @property string $time_audit
 * @property string $time_payment
 * @property integer $admin_uid_payment
 * @property integer $admin_uid_audit
 * @property integer $admin_uid_apply
 */
class WalletWithdrawcash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_withdrawcash}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'uid',
                    'money',
                    'payee_type',
                    'payee_time',
                    'payee_hospital',
                    'payee_name',
                    'payee_id_card',
                ],
                'required',
                'on'=>['applyCash']
            ],


            [['uid', 'status', 'payee_type', 'admin_uid_payment', 'admin_uid_audit', 'admin_uid_apply'], 'integer'],
            [['money'], 'number'],
            [['payee_time', 'time_apply', 'time_audit', 'time_payment'], 'safe'],
            [['withdrawcash_no', 'payee_name', 'payee_id_card'], 'string', 'max' => 50],
            [['remark_audit', 'remark_apply', 'payee_hospital'], 'string', 'max' => 255]
        ];
    }

    /**
     * 定义场景
     * @return array
     */
    public function scenarios()
    {
        return[
            'applyCash'=>['uid','money','payee_type','payee_time','payee_hospital','payee_name','payee_id_card',],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'withdrawcash_id' => '提现记录ID',
            'withdrawcash_no' => '提现记录编号',
            'uid' => '用户ID',
            'money' => '提现金额',
            'status' => '状态',
            'remark_audit' => '审核备注',
            'remark_apply' => '申请备注',
            'payee_type' => '收款方式',
            'payee_time' => '收款时间',
            'payee_hospital' => '取款医院',
            'payee_name' => '收款人姓名',
            'payee_id_card' => '收款人身份证',
            'time_apply' => '提现申请时间',
            'time_audit' => '提现审核时间',
            'time_payment' => '提现付款时间',
            'admin_uid_payment' => '付款管理员',
            'admin_uid_audit' => '审核管理员',
            'admin_uid_apply' => '申请管理员',
        ];
    }
}
