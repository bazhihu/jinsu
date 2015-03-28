<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WalletUser;

/**
 * WalletUserSearch represents the model behind the search form about `backend\models\WalletUser`.
 */
class WalletUserSearch extends WalletUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'integer'],
            [['money', 'money_pay', 'money_pay_s', 'money_consumption', 'money_extract'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WalletUser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'uid' => $this->uid,
            'money' => $this->money,
            'money_pay' => $this->money_pay,
            'money_pay_s' => $this->money_pay_s,
            'money_consumption' => $this->money_consumption,
            'money_extract' => $this->money_extract,
        ]);

        return $dataProvider;
    }
}
