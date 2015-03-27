<?php

namespace backend\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\Models\Workerother;

/**
 * WorkerotherSearch represents the model behind the search form about `backend\Models\Workerother`.
 */
class WorkerotherSearch extends Workerother
{
    public function rules()
    {
        return [
            [['worker_id', 'info_type'], 'integer'],
            [['ext1', 'ext2', 'ext3', 'ext4'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Workerother::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'worker_id' => $this->worker_id,
            'info_type' => $this->info_type,
        ]);

        $query->andFilterWhere(['like', 'ext1', $this->ext1])
            ->andFilterWhere(['like', 'ext2', $this->ext2])
            ->andFilterWhere(['like', 'ext3', $this->ext3])
            ->andFilterWhere(['like', 'ext4', $this->ext4]);

        return $dataProvider;
    }
}
