<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WalletWithdrawcash;

/**
 * WalletWithdrawcashSearch represents the model behind the search form about `\backend\models\WalletWithdrawcash`.
 */
class WalletWithdrawcashSearch extends WalletWithdrawcash
{
    public function rules()
    {
        return [
            [['withdrawcash_id', 'uid', 'status', 'payee_type', 'admin_uid_payment', 'admin_uid_audit', 'admin_uid_apply'], 'integer'],
            [['withdrawcash_no', 'remark_audit', 'remark_apply', 'payee_time', 'payee_hospital', 'payee_name', 'payee_id_card', 'time_apply', 'time_audit', 'time_payment'], 'safe'],
            [['money'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = WalletWithdrawcash::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'withdrawcash_id' => $this->withdrawcash_id,
            'uid' => $this->uid,
            'money' => $this->money,
            'status' => $this->status,
            'payee_type' => $this->payee_type,
            'payee_time' => $this->payee_time,
            'time_apply' => $this->time_apply,
            'time_audit' => $this->time_audit,
            'time_payment' => $this->time_payment,
            'admin_uid_payment' => $this->admin_uid_payment,
            'admin_uid_audit' => $this->admin_uid_audit,
            'admin_uid_apply' => $this->admin_uid_apply,
        ]);

        $query->andFilterWhere(['like', 'withdrawcash_no', $this->withdrawcash_no])
            ->andFilterWhere(['like', 'remark_audit', $this->remark_audit])
            ->andFilterWhere(['like', 'remark_apply', $this->remark_apply])
            ->andFilterWhere(['like', 'payee_hospital', $this->payee_hospital])
            ->andFilterWhere(['like', 'payee_name', $this->payee_name])
            ->andFilterWhere(['like', 'payee_id_card', $this->payee_id_card]);

        return $dataProvider;
    }
}
