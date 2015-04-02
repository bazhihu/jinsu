<?php

namespace common\models;

use Yii;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;
use yii\helpers\Inflector;
use ReflectionClass;

/**
 * This is the model class for table "tbl_user".
 *
 * @property string    $id
 * @property string    $role_id
 * @property integer   $status
 * @property string    $mobile
 * @property string    $email
 * @property string    $new_email
 * @property string    $username
 * @property string    $password
 * @property string    $auth_key
 * @property string    $api_key
 * @property string    $login_ip
 * @property string    $login_time
 * @property string    $create_ip
 * @property string    $create_time
 * @property string    $update_time
 * @property string    $ban_time
 * @property string    $ban_reason
 *
 * @property Profile   $profile
 * @property Role      $role
 * @property UserKey[] $userKeys
 * @property UserAuth[] $userAuths
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var int 禁用
     */
    const STATUS_DISABLED = 0;

    /**
     * @var int 正常
     */
    const STATUS_NORMAL = 1;

    /**
     * @var string 系统注册类型
     */
    const REGISTER_TYPE_SYSTEM = 'system';

    /**
     * @var string 用户注册类型
     */
    const REGISTER_TYPE_USER = 'user';

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
            [['type'], 'in', 'range' => [self::REGISTER_TYPE_SYSTEM, self::REGISTER_TYPE_USER]],

            [['gender'], 'string', 'max' => 1],
            [['name', 'login_ip', 'register_ip'], 'string', 'max' => 50]
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
     * Validate current password (account page)
     */
    public function validateCurrentPassword()
    {
        if (!$this->verifyPassword($this->currentPassword)) {
            $this->addError("currentPassword", "Current password incorrect");
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserKeys()
    {
        $userKey = Yii::$app->getModule("user")->model("UserKey");
        return $this->hasMany($userKey::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuths()
    {
        return $this->hasMany(UserAuth::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findByMobile($mobile)
    {
        return static::findOne(['mobile' => $mobile, 'status' => self::STATUS_NORMAL]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(["api_key" => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
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
        return $this->auth_key === $authKey;
    }

    /**
     * Verify password
     *
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Update login info (ip and time)
     *
     * @return bool
     */
    public function updateLoginMeta()
    {
        // set data
        $this->login_ip = Yii::$app->getRequest()->getUserIP();
        $this->login_time = date("Y-m-d H:i:s");

        // save and return
        return $this->save(false, ["login_ip", "login_time"]);
    }

    /**
     * Get display name for the user
     *
     * @var string $default
     * @return string|int
     */
    public function getDisplayName($default = "")
    {
        // define possible fields
        $possibleNames = [
            "nickname",
            "username",
            "mobile",
            //"email",
            "id",
        ];

        // go through each and return if valid
        foreach ($possibleNames as $possibleName) {
            if (!empty($this->$possibleName)) {
                return $this->$possibleName;
            }
        }

        return $default;
    }

}