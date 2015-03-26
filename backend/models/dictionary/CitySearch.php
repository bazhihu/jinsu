<?php

namespace backend\models\dictionary;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\dictionary\City;

/**
 * CitySearch represents the model behind the search form about `\backend\models\City`.
 */
class CitySearch extends City
{
    public function rules()
    {
        return [
            [['id', 'type', 'parent_id', 'group_id', 'display', 'continent_id'], 'integer'],
            [['name', 'zip', 'wcode'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = City::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'parent_id' => $this->parent_id,
            'group_id' => $this->group_id,
            'display' => $this->display,
            'continent_id' => $this->continent_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'zip', $this->zip])
            ->andFilterWhere(['like', 'wcode', $this->wcode]);

        return $dataProvider;
    }
}
