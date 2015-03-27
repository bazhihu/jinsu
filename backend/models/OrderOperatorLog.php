<?php

namespace backend\models;

use Yii;
use yii\base\ErrorException;

/**
 * This is the model class for table "{{%order_operator_log}}".
 *
 * @property string $id
 * @property string $order_id
 * @property string $order_no
 * @property string $action
 * @property string $remark
 * @property string $create_time
 * @property string $operator_id
 */
class OrderOperatorLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_operator_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_no', 'action', 'create_time', 'operator_id'], 'required'],
            [['operator_id'], 'integer'],
            [['create_time'], 'safe'],
            [['order_no'], 'string', 'max' => 50],
            [['action', 'remark'], 'string', 'max' => 255],
            [['result'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => '订单编号',
            'action' => '动作',
            'remark' => '备注',
            'result' => '操作结果',
            'create_time' => '创建时间',
            'operator_id' => 'Operator ID',
        ];
    }

    /**
     * 添加订单操作日志
     * @param string $orderNo 订单号
     * @param string $action 动作
     * @param array $result 操作结果
     * @param null $remark 备注
     * @return bool
     */
    public function addLog($orderNo, $action, $result, $remark = null){
        $attributes = [
            'order_no' => $orderNo,
            'action' => $action,
            'result' => json_encode($result),
            'remark' => $remark,
            'create_time' => date('Y-m-d H:i:s'),
            'operator_id' => Yii::$app->user->id
        ];
        $this->setAttributes($attributes);

        return $this->save();
    }
}
