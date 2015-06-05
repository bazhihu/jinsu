<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%patient}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property integer $gender
 * @property integer $age
 * @property integer $height
 * @property integer $weight
 * @property string $create_time
 */
class Patient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%patient}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','name'],'required'],
            [['user_id', 'gender', 'age', 'height', 'weight'], 'integer'],
            [['create_time'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @param bool $insert
     * @return bool|void
     */
    public function beforeSave($insert){
        if ($insert && parent::beforeSave($insert)) {
            $this->create_time = date('Y-m-d H:i:s');
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'name' => '患者名称',
            'gender' => '性别',
            'age' => '年龄',
            'height' => '身高',
            'weight' => '体重',
            'create_time' => '创建时间',
        ];
    }
}
