<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WorkerCard;

/**
 * WorkerCardSearch represents the model behind the search form about `\backend\models\WorkerCard`.
 */
class WorkerCardSearch extends WorkerCard
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
            [['worker_name', 'identity_card', 'bank', 'bank_card', 'add_date'], 'safe'],
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
        $query = WorkerCard::find();

        $this->status = 0;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->orderBy('id DESC');
        $query->andFilterWhere([
            'id' => $this->id,
            'worker_id' => $this->worker_id,
            'add_date' => $this->add_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'worker_name', $this->worker_name])
            ->andFilterWhere(['like', 'identity_card', $this->identity_card])
            ->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'bank_card', $this->bank_card])
            ->andFilterWhere(['>=', 'add_date', $this->fromDate])
            ->andFilterWhere(['<=', 'add_date', $this->toDate])
        ;

        return $dataProvider;
    }
}
