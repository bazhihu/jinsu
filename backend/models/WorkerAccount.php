<?php

namespace backend\models;

use Yii;
use yii\web\HttpException;

/**
 * This is the model class for table "{{%worker_account}}".
 *
 * @property string $id
 * @property integer $worker_id
 * @property string $worker_name
 * @property string $city_id
 * @property string $hospital_id
 * @property string $balance
 * @property string $withdraw_amount
 * @property string $recommend_amount
 * @property string $order_amount
 */
class WorkerAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%worker_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id', 'worker_name', 'city_id', 'hospital_id'], 'required'],
            [['worker_id', 'city_id', 'hospital_id'], 'integer'],
            [['balance', 'withdraw_amount', 'recommend_amount', 'order_amount'], 'number'],
            [['worker_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'worker_id' => '护工编号',
            'worker_name' => '护工姓名',
            'city_id' => '所属城市',
            'hospital_id' => '所属医院',
            'balance' => '账户余额',
            'withdraw_amount' => '提现金额',
            'recommend_amount' => '推荐收入金额',
            'order_amount' => '订单收入金额',
        ];
    }

    /**
     * 增加推荐金额
     * @param int $workerId 护工ID
     * @param int $amount 金额
     * @param array $data
     * @return bool
     * @throws HttpException
     */
    static public function addRecommendAmount($workerId, $amount, $data){
        $model = self::findOne($workerId);
        if(empty($model)){
            $model = new WorkerAccount();
            $model->worker_id = $workerId;
            $model->worker_name = $data['worker_name'];
            $model->city_id = $data['city_id'];
            $model->hospital_id = $data['hospital_id'];
        }
        $model->balance = $model->balance + $amount;
        $model->recommend_amount = $model->recommend_amount + $amount;
        if(!$model->save()){
            throw new HttpException(400, print_r($model->getErrors(), true));
        }
        return true;
    }

    /**
     * 增加订单金额
     * @param int $workerId 护工ID
     * @param int $amount 金额
     * @param array $data
     * @return bool
     * @throws HttpException
     */
    static public function addOrderAmount($workerId, $amount, $data){
        $model = self::findOne(['worker_id' => $workerId]);
        if(empty($model)){
            $model = new WorkerAccount();
            $model->worker_id = $workerId;
            $model->worker_name = $data['worker_name'];
            $model->city_id = $data['city_id'];
            $model->hospital_id = $data['hospital_id'];
        }
        $model->balance = $model->balance + $amount;
        $model->order_amount = $model->order_amount + $amount;
        if(!$model->save()){
            throw new HttpException(400, print_r($model->getErrors(), true));
        }
        return true;
    }

}
