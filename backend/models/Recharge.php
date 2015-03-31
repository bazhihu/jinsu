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
}