<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/4
 * Time: 18:59
 */

namespace common\models;

use Yii;
use yii\base\Model;

class Sms extends Model{
    public $mobile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile'], 'required', 'message'=>'手机号码不能为空']
        ];
    }

    /**
     * 发送短信验证码
     * @author zhangbo
     */
    public function send(){

    }

}