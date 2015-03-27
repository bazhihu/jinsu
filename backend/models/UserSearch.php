<?php

namespace backend\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\Models\User;

/**
 * UserSearch represents the model behind the search form about `backend\Models\User`.
 */
class UserSearch extends User
{
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['username', 'nickname', 'name'], 'safe'],
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

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
