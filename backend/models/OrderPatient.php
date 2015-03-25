<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%order_patient}}".
 *
 * @property string $id
 * @property string $order_id
 * @property string $order_no
 * @property string $name
 * @property integer $gender
 * @property integer $age
 * @property integer $height
 * @property integer $weight
 * @property integer $patient_state
 * @property string $in_hospital_reason
 * @property string $admission_date
 * @property string $room_no
 * @property string $bed_no
 * @property string $create_time
 */
class OrderPatient extends \yii\db\ActiveRecord
{
    /**
     * 患者健康状态
     */
    const PATIENT_STATE_OK = 1; //能自理
    const PATIENT_STATE_DISABLED = 2; //不能自理

    /**
     * 患者健康状态标签
     * @var array
     */
    static public $patientStateLabels = [
        self::PATIENT_STATE_OK => '能自理',
        self::PATIENT_STATE_DISABLED => '不能自理'
    ];

    /**
     * 患者健康状态对应价格
     * @var array
     */
    static public $patientStatePrice = [
        self::PATIENT_STATE_OK => 0,
        self::PATIENT_STATE_DISABLED => 0.3
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_patient}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'gender', 'age', 'height', 'weight', 'patient_state'], 'integer'],
            [['order_no','patient_state'], 'required'],
            [['patient_state'], 'in', 'range' => [self::PATIENT_STATE_DISABLED,self::PATIENT_STATE_OK]],
            [['admission_date', 'create_time'], 'safe'],
            [['order_no'], 'string', 'max' => 50],
            [['name', 'in_hospital_reason', 'room_no', 'bed_no'], 'string', 'max' => 255],
            [['order_id'], 'unique'],
            [['order_no'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单主表自增ID',
            'order_no' => '订单编号',
            'name' => '姓名',
            'gender' => '性别',
            'age' => '年龄',
            'height' => '身高',
            'weight' => '体重',
            'patient_state' => '患者健康状况',
            'in_hospital_reason' => '因何病入院',
            'admission_date' => '住院日期',
            'room_no' => '病房号',
            'bed_no' => '床号',
            'create_time' => '创建时间',
        ];
    }
}
