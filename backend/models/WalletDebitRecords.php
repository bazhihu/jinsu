<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%wallet_debit_records}}".
 *
 * @property string $id
 * @property string $trade_no
 * @property string $order_id
 * @property string $order_no
 * @property string $uid
 * @property string $mobile
 * @property string $money
 * @property string $balance
 * @property string $time
 * @property string $admin_uid
 * @property string $remark
 */
class WalletDebitRecords extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_debit_records}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trade_no', 'order_id', 'order_no', 'uid', 'mobile', 'time', 'admin_uid'], 'required'],
            [['order_id', 'uid', 'admin_uid'], 'integer'],
            [['money', 'balance'], 'number'],
            [['time'], 'safe'],
            [['trade_no', 'order_no', 'mobile', 'remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trade_no' => 'Trade No',
            'order_id' => 'Order ID',
            'order_no' => 'Order No',
            'uid' => 'Uid',
            'mobile' => 'Mobile',
            'money' => 'Money',
            'balance' => 'Balance',
            'time' => 'Time',
            'admin_uid' => 'Admin Uid',
            'remark' => 'Remark',
        ];
    }
}
