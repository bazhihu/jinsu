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
    //充值金额
    public $money;
    public $admin_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'money'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'uid' =>'用户ID',
            'money' => '充值金额',
            'mobile' => '用户帐号',
        ];
    }
}