<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\WorkerWithdrawcash;

/**
 * WorkerWithdrawcashSearch represents the model behind the search form about `\backend\models\WorkerWithdrawcash`.
 */
class WorkerWithdrawcashSearch extends WorkerWithdrawcash
{

    public $fromDate;   //申请提现开始时间
    public $toDate;     //申请提现结束时间

    public $payStartDate;//付款开始时间
    public $payEndDate;//付款开始时间

    public $start;      //起始状态
    public $end;        //结束状态
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'status', 'payee_type', 'admin_uid_payment', 'admin_uid_audit', 'admin_uid_apply'], 'integer'],
            [['withdrawcash_no', 'worker_name', 'remark_audit', 'remark_apply', 'payee_hospital', 'payee_id_card', 'payee_bank', 'payee_bank_card', 'time_apply', 'time_audit', 'time_payment'], 'safe'],
            [['money'], 'number'],
            [['fromDate','toDate','payStartDate','payEndDate','start','end'],'safe']
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
        $query = WorkerWithdrawcash::find();

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
            'id' => $this->id,
            'worker_id' => $this->worker_id,
            'money' => $this->money,
            'status' => $this->status,
            'payee_type' => $this->payee_type,
            'time_apply' => $this->time_apply,
            'time_audit' => $this->time_audit,
            'time_payment' => $this->time_payment,
            'admin_uid_payment' => $this->admin_uid_payment,
            'admin_uid_audit' => $this->admin_uid_audit,
            'admin_uid_apply' => $this->admin_uid_apply,
        ]);

        $query->andFilterWhere(['like', 'withdrawcash_no', $this->withdrawcash_no])
            ->andFilterWhere(['like', 'worker_name', $this->worker_name])
            ->andFilterWhere(['like', 'remark_audit', $this->remark_audit])
            ->andFilterWhere(['like', 'remark_apply', $this->remark_apply])
            ->andFilterWhere(['like', 'payee_hospital', $this->payee_hospital])
            ->andFilterWhere(['like', 'payee_id_card', $this->payee_id_card])
            ->andFilterWhere(['like', 'payee_bank', $this->payee_bank])
            ->andFilterWhere(['like', 'payee_bank_card', $this->payee_bank_card])
            ->andFilterWhere(['>=', 'status', $this->start])
            ->andFilterWhere(['<=', 'status', $this->end])
            ->andFilterWhere(['>=', 'time_apply', $this->fromDate])
            ->andFilterWhere(['<=', 'time_apply', $this->toDate])
            ->andFilterWhere(['<=', 'time_payment', $this->payStartDate])
            ->andFilterWhere(['<=', 'time_payment', $this->payEndDate]);;

        return $dataProvider;
    }
}
