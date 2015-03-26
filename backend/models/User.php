<?php

namespace backend\Models;

use Yii;
use yii\validators\EmailValidator;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
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
            [['username'],'required'],
            [['status', 'adder', 'editer'], 'integer'],
            [['login_date', 'add_date', 'edit_date'], 'safe'],
            [['username'], 'string', 'max' => 32],
            [['nickname'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
            [['name','login_ip'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'nickname' => '昵称',
            'name' => '姓名',
            'gender' => '性别',
            'type' => '注册类型',
            'status' => '状态',
            'login_ip' => '登陆IP',
            'login_date' => '登陆时间',
            'add_date' => '注册时间',
            'adder' => '注册人',
            'edit_date' => '编辑时间',
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
}
