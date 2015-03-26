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
            [['id', 'status', 'adder', 'editer'], 'integer'],
            [['username', 'nickname', 'type', 'login_ip', 'login_date', 'add_date', 'edit_date'], 'safe'],
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
            'id' => $this->id,
            'status' => $this->status,
            'login_date' => $this->login_date,
            'add_date' => $this->add_date,
            'adder' => $this->adder,
            'edit_date' => $this->edit_date,
            'editer' => $this->editer,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'login_ip', $this->login_ip]);

        return $dataProvider;
    }
}
