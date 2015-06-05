<?php

namespace backend\models;

use Yii;
use yii\web\HttpException;

/**
 * This is the model class for table "{{%worker_bill}}".
 *
 * @property string $id
 * @property string $type
 * @property string $worker_id
 * @property string $worker_name
 * @property string $order_id
 * @property string $order_no
 * @property string $start_time
 * @property string $end_time
 * @property string $amount
 * @property string $add_time
 */
class WorkerBill extends \yii\db\ActiveRecord
{
    const TYPE_ORDER = 'order';
    const TYPE_REFERRAL = 'referral';

    static public $types = [
        self::TYPE_ORDER => '订单收入',
        self::TYPE_REFERRAL => '推荐收入',
    ];

    public $total; //合计

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%worker_bill}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'worker_id', 'worker_name', 'order_id', 'order_no', 'start_time', 'end_time', 'amount'], 'required'],
            [['worker_id', 'order_id'], 'integer'],
            [['start_time', 'end_time', 'add_time'], 'safe'],
            [['amount'], 'number'],
            [['type', 'worker_name'], 'string', 'max' => 255],
            [['order_no'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '账单类型',
            'worker_id' => '护工ID',
            'worker_name' => '护工姓名',
            'order_id' => ' 订单ID',
            'order_no' => '订单编号',
            'start_time' => '订单开始时间',
            'end_time' => '订单结束时间',
            'amount' => '金额',
            'add_time' => '创建时间',
        ];
    }

    /**
     * @param bool $insert
     * @return bool|void
     */
    public function beforeSave($insert){
        if ($insert && parent::beforeSave($insert)) {
            $this->add_time = date('Y-m-d H:i:s');
        }
        return true;
    }

    /**
     * 添加账单
     * @param object $order
     * @return bool
     * @throws HttpException
     */
    public function addBill($order){
        $data = [
            'worker_id' => $order->worker_no,
            'worker_name' => $order->worker_name,
            'order_id' => $order->order_id,
            'order_no' => $order->order_no,
            'start_time' => $order->start_time,
            'end_time' => $order->reality_end_time,
            'city_id' => $order->city_id,
            'hospital_id' => $order->hospital_id
        ];

        $orderAmount = $order->total_amount;
        $profit = Yii::$app->params['city'][$order->city_id]['profit'];
        $data['type'] = self::TYPE_ORDER;
        $data['amount'] = $orderAmount - $profit;
        $this->setAttributes($data);
        if(!$this->save()){
            throw new HttpException(400, print_r($this->getErrors(), true));
        }

        //给护工添加订单所得的钱
        WorkerAccount::addOrderAmount($data['worker_id'], $data['amount'], $data);

        //判断是否有介绍人
        $worker = Worker::findOne($order->worker_no);
        if($worker->parent_worker_id > 0){
            $workerParent = Worker::findOne($worker->parent_worker_id);
            $data['type'] = self::TYPE_REFERRAL;
            $data['worker_id'] = $worker->parent_worker_id;
            $data['worker_name'] = $workerParent->name;
            $data['amount'] = Yii::$app->params['city'][$order->city_id]['referral_fee'];

            $this->setAttributes($data);
            if(!$this->save()){
                throw new HttpException(400, print_r($this->getErrors(), true));
            }

            //给护工添加推荐费
            WorkerAccount::addRecommendAmount($data['worker_id'], $data['amount'], $data);
        }

        return true;
    }

}
