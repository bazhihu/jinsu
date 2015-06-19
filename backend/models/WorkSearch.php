<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Work;

/**
 * WorkSearch represents the model behind the search form about `backend\Models\Work`.
 */
class WorkSearch extends Work
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_id', 'worker_id', 'adder', 'solver', 'status','type'], 'integer'],
            [['worker_name', 'content', 'from_where', 'mobile', 'user_name', 'add_date', 'add_date_begin','add_date_end','solve_date', 'solver_content'], 'safe'],
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
        $query = Work::find();

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
            'from_where' => $this->from_where,
            'type' => $this->type,
            'status' => $this->status
        ]);

        if(!$this->add_date_end)
            $this->add_date_end = date('Y-m-d H:i:s');
        $query->andFilterWhere(['like', 'worker_id', $this->worker_id])
            ->andFilterWhere(['like', 'worker_name', $this->worker_name])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['between', 'add_date', $this->add_date_begin, $this->add_date_end]);
        $query->orderBy('work_id DESC');

        return $dataProvider;
    }
}
