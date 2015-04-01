<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%wallet_user}}".
 *
 * @property integer $uid
 * @property string $money
 * @property string $money_pay
 * @property string $money_pay_s
 * @property string $money_consumption
 * @property string $money_extract
 */
class WalletUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wallet_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid'], 'integer'],
            [['money', 'money_pay', 'money_pay_s', 'money_consumption', 'money_extract'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户ID',
            'money' => 'Money',
            'money_pay' => 'Money Pay',
            'money_pay_s' => 'Money Pay S',
            'money_consumption' => 'Money Consumption',
            'money_extract' => 'Money Extract',
        ];
    }

    /**
     * 用户提现余额
     * @param $uid 用户ID
     * @return bool
     */
    public function purseCleared($uid){
        $user = $this->findOne(['uid'=>$uid]);
        $params = [
            'money'=>0,
            'money_extract'=>$user->money_extract + $user->money,
        ];
        if(!$this->updateAll($params,['uid'=>$uid])){
            return false;
        }
        return true;
    }
}
