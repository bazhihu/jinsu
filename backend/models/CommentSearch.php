<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `backend\models\Comment`.
 */
class CommentSearch extends Comment
{
    public function rules()
    {
        return [
            [['comment_id', 'order_no', 'uid', 'worker_id', 'star', 'status', 'adder', 'auditer'], 'integer'],
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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'worker_id', $this->worker_id])
            ->andFilterWhere(['like', 'worker_name', $this->worker_name])
            ->andFilterWhere(['between', 'comment_date', $this->comment_date_begin, $this->comment_date_end]);

        return $dataProvider;
    }
}
