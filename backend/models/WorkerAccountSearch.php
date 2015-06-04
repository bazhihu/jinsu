<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WorkerAccount;

/**
 * WorkerAccountSearch represents the model behind the search form about `backend\models\WorkerAccount`.
 */
class WorkerAccountSearch extends WorkerAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'city_id', 'hospital_id'], 'integer'],
            [['worker_name'], 'safe'],
            [['balance', 'withdraw_amount', 'recommend_amount', 'order_amount'], 'number'],
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
        $query = WorkerAccount::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'worker_id' => $this->worker_id,
            'city_id' => $this->city_id,
            'hospital_id' => $this->hospital_id,
            'balance' => $this->balance,
            'withdraw_amount' => $this->withdraw_amount,
            'recommend_amount' => $this->recommend_amount,
            'order_amount' => $this->order_amount,
        ]);

        $query->andFilterWhere(['like', 'worker_name', $this->worker_name]);

        return $dataProvider;
    }
}
