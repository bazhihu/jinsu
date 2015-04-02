<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WalletRechargeRecords;

/**
 * WalletRechargeRecordsSearch represents the model behind the search form about `\backend\models\WalletRechargeRecords`.
 */
class WalletRechargeRecordsSearch extends WalletRechargeRecords
{
    public $fromDate;
    public $toDate;

    public function rules()
    {
        return [
            [['id', 'uid', 'admin_uid'], 'integer'],
            [['trade_no', 'mobile', 'time', 'pay_from', 'remark'], 'safe'],
            [['money', 'balance'], 'number'],
            [['fromDate','toDate'],'safe']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = WalletRechargeRecords::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'money' => $this->money,
            'balance' => $this->balance,
            'admin_uid' => $this->admin_uid,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['>', 'time', $this->fromDate])
            ->andFilterWhere(['<', 'time', $this->toDate])
            ->andFilterWhere(['like', 'pay_from', $this->pay_from])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
