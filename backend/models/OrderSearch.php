<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderMaster;

/**
 * OrderSearch represents the model behind the search form about `backend\models\OrderMaster`.
 */
class OrderSearch extends OrderMaster
{
    public function rules()
    {
        return [
            [['order_id', 'uid', 'patient_state', 'worker_level', 'customer_service_id', 'operator_id'], 'integer'],
            [['order_no', 'mobile', 'start_time', 'end_time', 'reality_end_time', 'create_time', 'pay_time', 'confirm_time', 'cancel_time', 'order_status', 'create_order_ip', 'create_order_sources', 'create_order_user_agent'], 'safe'],
            [['base_price', 'disabled_amount', 'total_amount'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OrderMaster::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'uid' => $this->uid,
            'base_price' => $this->base_price,
            'disabled_amount' => $this->disabled_amount,
            'total_amount' => $this->total_amount,
            'patient_state' => $this->patient_state,
            'worker_level' => $this->worker_level,
            'customer_service_id' => $this->customer_service_id,
            'operator_id' => $this->operator_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'reality_end_time' => $this->reality_end_time,
            'create_time' => $this->create_time,
            'pay_time' => $this->pay_time,
            'confirm_time' => $this->confirm_time,
            'cancel_time' => $this->cancel_time,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'order_status', $this->order_status])
            ->andFilterWhere(['like', 'create_order_ip', $this->create_order_ip])
            ->andFilterWhere(['like', 'create_order_sources', $this->create_order_sources])
            ->andFilterWhere(['like', 'create_order_user_agent', $this->create_order_user_agent]);

        return $dataProvider;
    }
}
