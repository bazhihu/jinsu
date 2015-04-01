<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\Models\Comment;

/**
 * CommentSearch represents the model behind the search form about `backend\Models\Comment`.
 */
class CommentSearch extends Comment
{
    public function rules()
    {
        return [
            [['comment_id', 'order_id', 'uid', 'worker_id', 'star', 'status', 'adder', 'auditer'], 'integer'],
            [['content', 'comment_date', 'audit_time', 'type'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'worker_id' => $this->worker_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'worker_name', $this->worker_name])
            ->andFilterWhere(['like', 'worker_name', $this->worker_name])
            ->andFilterWhere(['between', 'comment_date', $this->comment_date_begin, $this->comment_date_end]);

        return $dataProvider;
    }
}
