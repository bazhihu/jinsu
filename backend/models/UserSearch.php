<?php

namespace backend\models;

use Yii;
use yii\base\model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['username', 'nickname', 'name','register_date_begin','register_date_end'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['between', 'register_time', $this->register_date_begin, $this->register_date_end]);;

        return $dataProvider;
    }
}