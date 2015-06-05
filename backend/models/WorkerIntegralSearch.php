<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WorkerIntegral;

/**
 * WorkerIntegralSearch represents the model behind the search form about `\backend\models\WorkerIntegral`.
 */
class WorkerIntegralSearch extends WorkerIntegral
{
    public $fromDate;//起始时间
    public $toDate;//结束时间
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'type', 'integral', 'cumulative'], 'integer'],
            [['time', 'remarks'], 'safe'],
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
        $query = WorkerIntegral::find();

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
            'time' => $this->time,
            'type' => $this->type,
            'integral' => $this->integral,
            'cumulative' => $this->cumulative,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
