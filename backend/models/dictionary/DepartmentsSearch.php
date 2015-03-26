<?php

namespace backend\models\dictionary;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\dictionary\Departments;

/**
 * DepartmentsSearch represents the model behind the search form about `backend\models\Departments`.
 */
class DepartmentsSearch extends Departments
{
    public function rules()
    {
        return [
            [['id', 'parent_id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Departments::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
