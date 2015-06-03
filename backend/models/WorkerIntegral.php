<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%worker_integral}}".
 *
 * @property string $id
 * @property string $time
 * @property integer $type
 * @property integer $integral
 * @property string $cumulative
 * @property string $remarks
 */
class WorkerIntegral extends \yii\db\ActiveRecord
{
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
            [['time', 'type', 'integral', 'cumulative', 'remarks'], 'required'],
            [['time'], 'safe'],
            [['type', 'integral', 'cumulative'], 'integer'],
            [['remarks'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'type' => 'Type',
            'integral' => 'Integral',
            'cumulative' => 'Cumulative',
            'remarks' => 'Remarks',
        ];
    }
}
