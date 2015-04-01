<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HospitalDepartmentRelation;

/**
 * HospitalDepartmentRelationSearch represents the model behind the search form about `\backend\models\HospitalDepartmentRelation`.
 */
class HospitalDepartmentRelationSearch extends HospitalDepartmentRelation
{
    public function rules()
    {
        return [
            [['id', 'hospital_id', 'department_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = HospitalDepartmentRelation::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'hospital_id' => $this->hospital_id,
            'department_id' => $this->department_id,
        ]);

        return $dataProvider;
    }
}
