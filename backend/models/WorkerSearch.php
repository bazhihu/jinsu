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
            'gender' => $this->gender,
            'birth' => $this->birth,
            'native_province' => $this->native_province,
            'level' => $this->level,
            'status' => $this->status,
            'chinese_level' => $this->chinese_level,
            'star' => $this->star,
            /*
            'marriage' => $this->marriage,
            'education' => $this->education,
            'politics' => $this->politics,

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
*/

        ]);

        $query->andFilterWhere(['like', 'worker_id', $this->worker_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'hospital_id', $this->hospital_id ? ','.$this->hospital_id.',':''])
            ->andFilterWhere(['like', 'good_at', $this->good_at? ','.$this->good_at.',':''])
          //  ->andFilterWhere(["($this->hospital_id,", "find_in_set", "hospital_id)"])
            /*->andFilterWhere(['like', 'birth_place', $this->birth_place])
            ->andFilterWhere(['like', 'native_province', $this->native_province])
            ->andFilterWhere(['like', 'idcard', $this->idcard])
            ->andFilterWhere(['like', 'certificate', $this->certificate])
            ->andFilterWhere(['like', 'place', $this->place])
            ->andFilterWhere(['like', 'hospital_id', $this->hospital_id])
            ->andFilterWhere(['like', 'office_id', $this->office_id])
            ->andFilterWhere(['like', 'good_at', $this->good_at])*/;

        return $dataProvider;
    }

    /**
     * 护工选择
     * @param $params
     * @return ActiveDataProvider
     * @author zhangbo
     */
    public function select($params){
        //获取在工作中的护工
        $workerIds = WorkerSchedule::getWorkingByDate($params['start_time']);

        $query = Worker::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $birth = null;
        if(!empty($params['birth'])){
            $birth = date('Y')-$params['birth'];
        }
        if(!empty($workerIds)){
            $query->andFilterWhere(['NOT IN', 'worker_id', $workerIds]);
        }

        if (!$this->load($params)) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'gender' => $this->gender,
            'birth' => $birth,
            'native_province' => $this->native_province,
            'level' => $this->level,
            'status' => $this->status,
            'chinese_level' => $this->chinese_level,
            'star' => $this->star,

        ]);

        $query->andFilterWhere(['like', 'worker_id', $this->worker_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'hospital_id', $this->hospital_id ? ','.$this->hospital_id.',':''])
            ->andFilterWhere(['like', 'good_at', $this->good_at? ','.$this->good_at.',':'']);


        return $dataProvider;
    }
}
