<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WorkerBill;

/**
 * WorkerBillSearch represents the model behind the search form about `backend\models\WorkerBill`.
 */
class WorkerBillSearch extends WorkerBill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'order_id'], 'integer'],
            [['type', 'worker_name', 'order_no', 'start_time', 'end_time', 'add_time'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WorkerBill::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            $this->total = $query->sum('amount');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'worker_id' => $this->worker_id,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'add_time' => $this->add_time,
        ]);

        $query->andFilterWhere(['>=', 'start_time', $this->start_time])
            ->andFilterWhere(['<=', 'end_time', $this->end_time])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'worker_name', $this->worker_name])
            ->andFilterWhere(['like', 'order_no', $this->order_no]);

        $this->total = $query->sum('amount');
        return $dataProvider;
    }
}
