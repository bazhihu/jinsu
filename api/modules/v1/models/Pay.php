<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/18
 * Time: 17:42
 */

namespace api\modules\v1\models;

use Yii;
use \yii\db\ActiveRecord;

class Pay extends ActiveRecord{
    public $amount; //充值金额
    public $pay_way; //支付方式
    public $uid; //用户ID

    public $openId;//微信用户公共ID

    public function rules()
    {
        return [
            [['pay_way','uid','amount'], 'required'],
            ['uid', 'checkUid'],
            ['openId', 'required' ,'on'=>['wechat']]
        ];
    }

    public function scenarios(){
        return [
            'alipay'=>['pay_way', 'uid', 'amount'],
            'wechat'=>['pay_way', 'uid', 'amount', 'openId'],
        ];
    }

    public function checkUid($attribute){

        if (!$this->hasErrors()) {
            if($this->uid != Yii::$app->user->id){
                $this->addError($attribute, '用户身份错误。');
            }else{
                return true;
            }
        }
    }




}