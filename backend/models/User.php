<?php

namespace backend\models;

use Yii;
use yii\validators\EmailValidator;
/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $mobile
 * @property string $nickname
 * @property string $type
 * @property integer $status
 * @property string $login_ip
 * @property string $login_date
 * @property string $add_date
 * @property integer $adder
 * @property string $edit_date
 * @property integer $editer
 *
 * @property Profile[] $profiles
 * @property UserAuth[] $userAuths
 * @property UserKey[] $userKeys
 */

/**
 * Class User
 * @package backend\models
 */
class User extends \common\models\User
{
    /**
     * 系统自动注册
     * @return $this
     * @throws ErrorException
     */
    public function SystemSignUp(){
        $attributes = [
            'type'      => self::REGISTER_TYPE_SYSTEM,
            "register_ip" => Yii::$app->request->userIP,
            'register_time' => date('Y-m-d H:i:s'),
            "status"    => static::STATUS_NORMAL,
        ];

        $this->setAttributes($attributes, false);

        //print_r($this->attributes);exit;
        if(!$this->save()){
            throw new ErrorException(print_r($this->getErrors(), true));
        }
        return $this;

    }
}