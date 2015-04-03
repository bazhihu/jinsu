<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class AdminUser extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $password;//密码
    public $pwd;//重复密码

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username','filter','filter'=>'trim'],
            ['username','unique','targetClass'=>'\backend\models\AdminUser', 'message' => '帐号已存在'],
            [['username','staff_name',],'string','min'=>2,'max'=>20],

            [['username','staff_name','staff_role','hospital','phone'],'required'],
            [['password','pwd'],'required','on'=>['create']],
            [['password','pwd'],'string','min' => 6,'max'=>20],

            ['pwd','compare','compareAttribute'=>'password'],
            ['pwd','safe'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            [['hospital', 'phone', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'staff_name', 'staff_role'], 'string', 'max' => 255],
            [['auth_key', 'staff_id'], 'string', 'max' => 32]
        ];
    }

    public function attributeLabels()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            'admin_uid' => '管理用户ID',
            'username' => '帐号',
            'auth_key' => 'Auth Key',
            'password'=>'密码',
            'pwd'=>'重复密码',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'staff_id' => '员工号',
            'staff_name' => '员工姓名',
            'staff_role' => '员工职位',
            'hospital' => '所属医院',
            'phone' => '电话号码',
            'created_at' => '创建时间',
            'updated_at' => 'Updated At',
            'status' => '状态',
            'created_id' => '创建人',
            'modifier_id' => '修改人',
        ];
    }

    /**
     * @desc 用于注册数据补充和操作记录
     * @author 2015-3-20 hu
     * @return bool
     */
    public function create()
    {
        #权限验证
        $admin_uid = yii::$app->user->identity->getId();
        if(yii::$app->authManager->checkAccess($admin_uid,"创建".$this->staff_role))
        {
            $params = [
                'created_id'    =>  yii::$app->user->identity->getId(),
                'staff_id'      => $this->staff_name,
                'password_hash' => \yii::$app->Security->generatePasswordHash($this->password),
            ];
            $this->setAttributes($params);
            //var_dump($this->attributes);exit;
            #保存信息
            if($this->save())
            {
                #授予权限
                $info = $this->findOne(['username'=>$this->username]);
                yii::$app->authManager->assign(Yii::$app->authManager->getRole($this->getAttribute("staff_role")),$info->getId());

                return true;
            }else{
                throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
            }
        }else{
            $this->addError('staff_role','权限不足');
            return false;
        }
    }

    /**
     * @desc 获取用户的信息
     * @author 2015-3-20 hu
     * @return $info
     */
    public static function getInfo($id)
    {
        return self::findOne(['admin_uid'=>$id])->username;
    }

    /**
     * @desc 编辑用户
     * @author 2015-3-20 hu
     * @return bool
     */
    public function up()
    {
        #权限验证
        $admin_uid = Yii::$app->user->identity->getId();
        #当前用户没有权限操作自己
        if($admin_uid!==$this->getAttribute('admin_uid')/* && yii::$app->authManager->checkAccess($admin_uid,"创建".$this->getAttribute("staff_role"))*/)
        {
            $this->setAttribute('modifier_id',yii::$app->user->identity->getId());

            #保存信息
            if($this->save())
            {
                #授予权限
                $info = $this->findOne(['username'=>$this->username]);
                yii::$app->authManager->revokeAll($info->getId());
                yii::$app->authManager->assign(Yii::$app->authManager->getRole($this->getAttribute("staff_role")),$info->getId());
                #添加操作记录

                return true;
            }
        }else{
            $this->addError('staff_role','权限不足');
            return false;
        }
    }

    /**
     * @注册时密码转换hash
     * @param bool $insert
     * @return bool
     */
    /*public function beforeSave($insert) {

//        if(empty($this->staff_id))
//            $this->staff_id = $this->staff_name;
//        if(isset($this->password))
//            $this->password_hash = \yii::$app->Security->generatePasswordHash($this->password);
        return parent::beforeSave($insert);
    }*/

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['admin_uid' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @desc 获取所有职位
     * @return $return[]
     */
    static function getRoles(){
        $staff_role = Yii::$app->authManager->getRoles();
        foreach(ArrayHelper::toArray($staff_role) as $val){
            if($val['name'] !== '系统管理员'){
                $return[$val['name']] = $val['name'];
            }
        }
        return $return;
    }
}
