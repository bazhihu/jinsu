<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WorkerSearch represents the model behind the search form about `backend\models\Worker`.
 */
class WorkerSearch extends Worker
{
    public function rules()
    {
        return [
            [['worker_id', 'nation', 'marriage', 'education', 'politics', 'chinese_level', 'phone1', 'phone2', 'adder', 'editer', 'total_score', 'star', 'total_order', 'total_comment', 'level', 'status','audit_status'], 'integer'],
            [['name', 'birth', 'birth_place', 'native_province', 'idcard', 'certificate', 'start_work', 'place', 'hospital_id', 'office_id', 'gender', 'add_date', 'edit_date'], 'safe'],
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
        $query = Worker::find()
            ->andFilterWhere(['like', 'hospital_id', ','.Yii::$app->user->identity->hospital_id.','])
            ->orderBy('worker_id DESC');

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
            'audit_status' => $this->audit_status,
            'chinese_level' => $this->chinese_level,
            'star' => $this->star,
        ]);

        $query->andFilterWhere(['like', 'worker_id', $this->worker_id])
            ->andFilterWhere(['like', 'name', $this->name]);
            //->andFilterWhere(['like', 'hospital_id', $this->hospital_id ? ','.$this->hospital_id.',':''])
            //->andFilterWhere(['like', 'good_at', $this->good_at? ','.$this->good_at.',':''])
            //->andFilterWhere(["($this->hospital_id,", "find_in_set", "hospital_id)"])

       $query->orderBy('worker_id DESC');

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

        if(!empty($params['hospital_id'])){
            $this->hospital_id = $params['hospital_id'];
            $query->andFilterWhere(['like', 'hospital_id', ','.$params['hospital_id'].',']);
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

        return $dataProvider;
    }
}
