<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WorkerLeave;

/**
 * WorkerLeaveSearch represents the model behind the search form about `\backend\models\WorkerLeave`.
 */
class WorkerLeaveSearch extends WorkerLeave
{
    public $fromDate;//起始时间
    public $toDate;//结束时间
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'status'], 'integer'],
            [['worker_name', 'start_time', 'end_time', 'real_end', 'leave_cause'], 'safe'],
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
        $query = WorkerLeave::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->orderBy('id DESC');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'worker_id' => $this->worker_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'real_end' => $this->real_end,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'worker_name', $this->worker_name])
            ->andFilterWhere(['like', 'leave_cause', $this->leave_cause])
            ->andFilterWhere(['>=', 'start_time', $this->fromDate])
            ->andFilterWhere(['<=', 'end_time', $this->toDate])
        ;

        return $dataProvider;
    }
}
