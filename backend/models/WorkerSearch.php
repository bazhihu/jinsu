<?php

namespace backend\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\Models\Worker;

/**
 * WorkerSearch represents the model behind the search form about `backend\Models\Worker`.
 */
class WorkerSearch extends Worker
{
    public function rules()
    {
        return [
            [['worker_id', 'gender', 'nation', 'marriage', 'education', 'politics', 'chinese_level', 'phone1', 'phone2', 'adder', 'editer', 'total_score', 'star', 'total_order', 'total_comment', 'level', 'status'], 'integer'],
            [['name', 'birth', 'birth_place', 'native_province', 'idcard', 'certificate', 'start_work', 'place', 'hospital_id', 'office_id', 'good_at', 'add_date', 'edit_date'], 'safe'],
            [['price', 'good_rate'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Worker::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'worker_id' => $this->worker_id,
            'gender' => $this->gender,
            'birth' => $this->birth,
            'nation' => $this->nation,
            'marriage' => $this->marriage,
            'education' => $this->education,
            'politics' => $this->politics,
            'chinese_level' => $this->chinese_level,
            'start_work' => $this->start_work,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'price' => $this->price,
            'add_date' => $this->add_date,
            'adder' => $this->adder,
            'edit_date' => $this->edit_date,
            'editer' => $this->editer,
            'total_score' => $this->total_score,
            'star' => $this->star,
            'total_order' => $this->total_order,
            'good_rate' => $this->good_rate,
            'total_comment' => $this->total_comment,
            'level' => $this->level,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'birth_place', $this->birth_place])
            ->andFilterWhere(['like', 'native_province', $this->native_province])
            ->andFilterWhere(['like', 'idcard', $this->idcard])
            ->andFilterWhere(['like', 'certificate', $this->certificate])
            ->andFilterWhere(['like', 'place', $this->place])
            ->andFilterWhere(['like', 'hospital_id', $this->hospital_id])
            ->andFilterWhere(['like', 'office_id', $this->office_id])
            ->andFilterWhere(['like', 'good_at', $this->good_at]);

        return $dataProvider;
    }
}
