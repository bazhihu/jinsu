<?php

namespace backend\models;

use common\models\Wallet;
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
            [['money', 'freeze_money', 'money_pay', 'money_pay_s', 'money_consumption', 'money_extract'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户帐号',
            'money' => '账户余额',
            'freeze_money'=>'账户申请冻结金额',
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
    public function purseCleared($uid,$money){
        $user = $this->findOne(['uid'=>$uid]);
        $params = [
            'money'=>$user->money-$money,
            'freeze_money'=>0,
            'money_extract'=>$user->money_extract + $money,
        ];

        if($params['money']<0){
            return false;
        }
        if(!$this->updateAll($params,['uid'=>$uid])){
            return false;
        }

        #添加消费记录
        $detail = [
            'uid'=>$uid,
            'detail_money'=>$money,
            'detail_type'=>WalletUserDetail::WALLET_TYPE_WITHDRAWALS,
            'wallet_money'=>$params['money'],
            'extract_to'=>WalletUserDetail::WITHDRAW_CHANNELS_BACKEND,
            'admin_uid'=>Yii::$app->user->identity->getId(),
        ];
        if(!Wallet::addUserDetail($detail)){
            return false;
        }
        return true;
    }

    /**
     * 冻结金额
     * @param $uid
     * @return bool
     */
    public static function freeze($uid){
        $model = self::findOne(['uid'=>$uid]);
        $model->freeze_money = $model->money;

        if(!$model->save()){
            return false;
        }
        return true;
    }
}