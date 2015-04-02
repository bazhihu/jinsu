<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WalletRefundRecords;

/**
 * WalletRefundRecordsSearch represents the model behind the search form about `\backend\models\WalletRefundRecords`.
 */
class WalletRefundRecordsSearch extends WalletRefundRecords
{
    public function rules()
    {
        return [
            [['id', 'order_id', 'uid', 'admin_uid'], 'integer'],
            [['trade_no', 'order_no', 'mobile', 'time', 'remark'], 'safe'],
            [['money', 'balance'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = WalletRefundRecords::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'uid' => $this->uid,
            'money' => $this->money,
            'balance' => $this->balance,
            'time' => $this->time,
            'admin_uid' => $this->admin_uid,
        ]);

        $query->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
