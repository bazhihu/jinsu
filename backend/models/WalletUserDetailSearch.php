<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WalletUserDetail;

/**
 * WalletUserDetailSearch represents the model behind the search form about `backend\models\WalletUserDetail`.
 */
class WalletUserDetailSearch extends WalletUserDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detail_id', 'order_id', 'worker_id', 'uid', 'detail_type', 'admin_uid'], 'integer'],
            [['detail_id_no', 'order_no', 'detail_time', 'remark', 'pay_from', 'extract_to'], 'safe'],
            [['detail_money', 'wallet_money'], 'number'],
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
        $query = WalletUserDetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'detail_id' => $this->detail_id,
            'order_id' => $this->order_id,
            'worker_id' => $this->worker_id,
            'uid' => $this->uid,
            'detail_money' => $this->detail_money,
            'detail_type' => $this->detail_type,
            'wallet_money' => $this->wallet_money,
            'detail_time' => $this->detail_time,
            'admin_uid' => $this->admin_uid,
        ]);

        $query->andFilterWhere(['like', 'detail_id_no', $this->detail_id_no])
            ->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'pay_from', $this->pay_from])
            ->andFilterWhere(['like', 'extract_to', $this->extract_to]);

        return $dataProvider;
    }
}
