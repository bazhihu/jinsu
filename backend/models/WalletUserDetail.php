<?php

namespace backend\models;

use Yii;

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
            [['detail_id_no', 'detail_time', 'remark', 'pay_from', 'extract_to', 'admin_uid','detail_money','detail_type'], 'required'],
            [['order_id', 'worker_id', 'uid', 'detail_type', 'admin_uid'], 'integer'],
            [['detail_money', 'wallet_money'], 'number'],
            [['detail_time'], 'safe'],
            [['detail_id_no', 'order_no', 'pay_from', 'extract_to'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 255]
        ];
    }
    public function scenarios()
    {
        return[
            'pay_create'=>['detail_money','detail_type'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'detail_id' => 'Detail ID',
            'detail_id_no' => 'Detail Id No',
            'order_id' => 'Order ID',
            'order_no' => 'Order No',
            'worker_id' => 'Worker ID',
            'uid' => 'Uid',
            'detail_money' => 'Detail Money',
            'detail_type' => 'Detail Type',
            'wallet_money' => 'Wallet Money',
            'detail_time' => 'Detail Time',
            'remark' => 'Remark',
            'pay_from' => 'Pay From',
            'extract_to' => 'Extract To',
            'admin_uid' => 'Admin Uid',
        ];
    }
}
