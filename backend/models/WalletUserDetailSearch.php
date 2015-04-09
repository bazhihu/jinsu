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
    public $fromDate;//起始时间
    public $toDate;//结束时间
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detail_id', 'order_id', 'worker_id', 'uid', 'detail_type', 'admin_uid'], 'integer'],
            [['uid', 'mobile', 'detail_no', 'order_no', 'detail_time', 'remark', 'pay_from', 'extract_to'], 'safe'],
            [['detail_money', 'wallet_money'], 'number'],
            [['fromDate','toDate'],'safe']
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
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $query->orderBy('detail_id DESC');

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
            //'detail_time' => $this->detail_time,
            'admin_uid' => $this->admin_uid,
        ]);

        $query->andFilterWhere(['like', 'detail_no', $this->detail_no])
            ->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['>', 'detail_time', $this->fromDate])
            ->andFilterWhere(['<', 'detail_time', $this->toDate])
            ->andFilterWhere(['like', 'pay_from', $this->pay_from])
            ->andFilterWhere(['like', 'extract_to', $this->extract_to]);

        return $dataProvider;
    }
}
