<?php

namespace backend\models;

use common\models\Sms;
use Yii;

/**
 * This is the model class for table "{{%send_message}}".
 *
 * @property string $id
 * @property string $subject
 * @property string $receiver
 * @property string $send_time
 * @property string $operator_id
 * @property integer $status
 */
class SendMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%send_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'receiver', 'send_time', 'operator_id'], 'required'],
            [['receiver'], 'string'],
            [['send_time'], 'safe'],
            [['operator_id', 'status'], 'integer'],
            [['subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => '短信内容',
            'receiver' => '接收者',
            'send_time' => '发送时间',
            'operator_id' => '发送者',
            'status' => 'Status',
        ];
    }

    /**
     *
     * @return bool
     */
    public function create(){
        $phone = '';
        $this->send_time = date("Y-m-d H:i:s");
        $this->operator_id = yii::$app->user->identity->getId();
        if($this->receiver){
            $phone = explode(',',$this->receiver);
            if(!$phone){
                $this->addError('receiver','电话号码错误！');
                return false;
            }
            foreach($phone as $key=>$val){
                if(!preg_match("/^1[0-9]{10}$/",$val)){
                    $this->addError('receiver','电话号码错误！');
                    return false;
                }
            }
        }
        if(!$this->save()){
            return false;
        }
        $sms = new Sms();
        foreach($phone as $key=>$val){
            $params = [
                'mobile'    => $val,
                'content'    => $this->subject
            ];
            $result = $sms->send($params);
            if($result['code'] != 200){
                return false;
            }
        }
        return true;
    }
}
