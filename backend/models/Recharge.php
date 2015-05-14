<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Recharge form
 */
class Recharge extends Model
{
    public $uid;
    public $mobile;
    public $pay_from;

    //充值金额
    public $money;
    public $admin_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'money', 'pay_from'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'uid' =>'用户ID',
            'money' => '充值金额',
            'mobile' => '用户帐号',
            'pay_from' => '充值渠道'
        ];
    }
}