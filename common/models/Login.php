<?php
/**
 * Created by PhpStorm.
 * User: zhangbo
 * Date: 2015/4/4
 * Time: 13:49
 */

namespace common\models;

use Yii;
use yii\base\Model;

class Login extends Model{
    public $mobile;
    public $authCode;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile'], 'required', 'message'=>'手机号码不能为空'],
            [['authCode'], 'required', 'message'=>'验证码不能为空'],

            // 短信验证码验证 by validateAuthCode()
            ['authCode', 'validateAuthCode'],
        ];
    }


    /**
     * 验证短信验证码
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateAuthCode($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || $this->authCode != $this->getAuthCode()) {
                $this->addError($attribute, '验证码错误。');
            }else{
                $this->flushAccessToken();
            }
        }
    }

    /**
     * 刷新token
     */
    public function flushAccessToken(){
        $user = $this->getUser();
        if(isset($user->access_token) && strlen($user->access_token) == 32){
            return null;
        }

        $user->access_token = Yii::$app->security->generateRandomString(32);
        $user->save();
    }

    /**
     * 加密token
     * @param $token
     * @return string
     */
    public static function encryptToken($token){
        return base64_encode(Yii::$app->security->encryptByKey($token, '123456'));
    }

    /**
     * 获取短信验证码
     * @return int
     */
    public function getAuthCode(){
        $authCode = 123456;
        return $authCode;
    }


    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByMobile($this->mobile);
        }

        return $this->_user;
    }
}