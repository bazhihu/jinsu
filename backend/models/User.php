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
class User extends \yii\db\ActiveRecord
{
    /**
     * @var string 系统注册类型
     */
    const REGISTER_TYPE_SYSTEM = 'system';

    /**
     * @var string 用户注册类型
     */
    const REGISTER_TYPE_USER = 'user';

    /**
     * @var int 禁用
     */
    const STATUS_DISABLED = 0;

    /**
     * @var int 正常
     */
    const STATUS_NORMAL = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile'], 'filter', 'filter' => 'trim'],
            [['mobile'], 'required'],
            [['mobile'], 'unique', 'message' => '{attribute}已注册.'],
            [['mobile'], 'string', 'min' => 11, 'max' => 11],

            [['status', 'adder', 'editer'], 'integer'],
            [['login_time', 'register_time', 'edit_time'], 'safe'],
            [['nickname'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],

            //注册类型
            [['type'], 'required'],
            [['type'], 'in', 'range' => [self::REGISTER_TYPE_SYSTEM,self::REGISTER_TYPE_USER]],

            [['gender'], 'string', 'max' => 1],
            [['name','login_ip','register_ip'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => '手机号',
            'nickname' => '昵称',
            'name' => '姓名',
            'gender' => '性别',
            'type' => '注册类型',
            'status' => '账号状态',
           // 'finance_status' => '财务状态',
            'register_ip' => '注册IP',
            'login_ip' => '登陆IP',
            'login_time' => '登陆时间',
            'register_time' => '注册时间',
            'adder' => '注册人',
            'edit_time' => '编辑时间',
            'editer' => '编辑人',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuths()
    {
        return $this->hasMany(UserAuth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserKeys()
    {
        return $this->hasMany(UserKey::className(), ['user_id' => 'id']);
    }


    public static function findByMobile($mobile)
    {
        return static::findOne(['mobile' => $mobile, 'status' => self::STATUS_NORMAL]);
    }

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