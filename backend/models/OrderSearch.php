<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrderMaster;

/**
 * OrderSearch represents the model behind the search form about `backend\models\OrderMaster`.
 */
class OrderSearch extends OrderMaster
{
    public function rules()
    {
        return [
            [['order_no', 'uid', 'hospital_id', 'patient_state', 'worker_level', 'worker_no'], 'integer'],
            [['order_no', 'mobile', 'start_time', 'end_time', 'order_status', 'create_order_ip'], 'safe'],
            [['total_amount'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = OrderMaster::find();

        //内勤人员限制，只能看到本医院的订单
        if(Yii::$app->user->identity->staff_role == AdminUser::BACKOFFICESTAFF){
            $query->andFilterWhere(['hospital_id' => Yii::$app->user->identity->hospital_id]);
        }

        !isset($params['sort']) && $query->orderBy('order_id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // enable sorting for the related columns
        $addSortAttributes = ["profile.full_name"];
        foreach ($addSortAttributes as $addSortAttribute) {
            $dataProvider->sort->attributes[$addSortAttribute] = [
                'asc'   => [$addSortAttribute => SORT_ASC],
                'desc'  => [$addSortAttribute => SORT_DESC],
            ];
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'order_no' => $this->order_no,
            'uid' => $this->uid,
            'total_amount' => $this->total_amount,
            'patient_state' => $this->patient_state,
            'worker_no' => $this->worker_no,
            'mobile' => $this->mobile,
            'order_status' => $this->order_status
        ]);

        $query->andFilterWhere(['>=', 'start_time', $this->start_time])
            ->andFilterWhere(['<=', 'end_time', $this->end_time]);

        !isset($params['sort']) && $query->orderBy('order_id DESC');
        return $dataProvider;
    }
}
