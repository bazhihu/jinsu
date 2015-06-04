<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%worker_integral}}".
 *
 * @property string $id
 * @property string $worker_id
 * @property string $time
 * @property integer $type
 * @property integer $integral
 * @property string $cumulative
 * @property string $remarks
 */
class WorkerIntegral extends \yii\db\ActiveRecord
{
    const WORKER_INTEGRAL_TYPE_ONE      = 1;

    #积分类型
    public static $IntegralType = [
        self::WORKER_INTEGRAL_TYPE_ONE      =>'用户评价',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%worker_integral}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id', 'time', 'type', 'integral', 'cumulative', 'remarks'], 'required'],
            [['worker_id', 'type', 'integral', 'cumulative'], 'integer'],
            [['time'], 'safe'],
            [['remarks'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'worker_id' => '护工编号',
            'time' => '时间',
            'type' => '类别',
            'integral' => '积分情况',
            'cumulative' => '累积积分',
            'remarks' => '备注',
        ];
    }
}
