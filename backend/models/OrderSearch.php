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
    public $total; //合计

    public function rules()
    {
        return [
            [['order_no', 'uid', 'hospital_id', 'department_id', 'worker_level', 'worker_no'], 'integer'],
            [['order_no', 'mobile', 'patient_name', 'start_time', 'end_time', 'reality_end_time', 'order_status', 'worker_name'], 'safe'],
            [['total_amount'], 'number'],
            [['start_time', 'end_time'], 'required', 'on'=>'chart'],
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
        //Yii::error();

        if (!($this->load($params) && $this->validate())) {
            $this->total = $query->sum('real_amount');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'order_no' => $this->order_no,
            'uid' => $this->uid,
            'total_amount' => $this->total_amount,
            'patient_state' => $this->patient_state,
            'worker_no' => $this->worker_no,
            'mobile' => $this->mobile,
            'department_id' => $this->department_id,
            'order_status' => $this->order_status
        ]);

        $query->andFilterWhere(['>=', 'start_time', $this->start_time])
            ->andFilterWhere(['<=', 'end_time', $this->end_time])
            ->andFilterWhere(['like', 'worker_name', $this->worker_name])
            ->andFilterWhere(['like', 'patient_name', $this->patient_name]);

        //!isset($params['sort']) && $query->orderBy('reality_end_time ASC');
        $this->total = $query->sum('real_amount');
        return $dataProvider;
    }

    public function chart($params){
        $params = isset($params['OrderSearch']) ? $params['OrderSearch'] : null;
        if(empty($params['start_time'])){
            $this->start_time = date('Y-m-d', strtotime(date('Y-m-d'))-(86400*30));
        }else{
            $this->start_time = $params['start_time'];
        }
        if(empty($params['end_time'])){
            $this->end_time = date('Y-m-d');
        }else{
            $this->end_time = $params['end_time'];
        }
        $result = [];
        $connection = Yii::$app->db;

        //每天的订单量
        $column = "count(*) as total,DATE_FORMAT(create_time,'%Y-%m-%d') as date";
        $where = "DATE_FORMAT(create_time,'%Y-%m-%d')>='$this->start_time' AND DATE_FORMAT(create_time,'%Y-%m-%d')<='$this->end_time'";
        $groupBy = "DATE_FORMAT(create_time,'%Y-%m-%d')";
        $sql = "SELECT $column FROM yayh_order_master WHERE $where GROUP BY $groupBy";
        //echo $sql;exit;
        $command = $connection->createCommand($sql);
        $result['all'] = $command->queryAll();


        //移动端
        $column = "count(*) as total,DATE_FORMAT(create_time,'%Y-%m-%d') as date";
        $where = "DATE_FORMAT(create_time,'%Y-%m-%d')>='$this->start_time' AND DATE_FORMAT(create_time,'%Y-%m-%d')<='$this->end_time' AND create_order_sources='".OrderMaster::ORDER_SOURCES_MOBILE."'";
        $groupBy = "DATE_FORMAT(create_time,'%Y-%m-%d')";
        $sql = "SELECT $column FROM yayh_order_master WHERE $where GROUP BY $groupBy";
        $command = $connection->createCommand($sql);
        $result['mobile'] = $command->queryAll();

        //后台
        $column = "count(*) as total,DATE_FORMAT(create_time,'%Y-%m-%d') as date";
        $where = "DATE_FORMAT(create_time,'%Y-%m-%d')>='$this->start_time' AND DATE_FORMAT(create_time,'%Y-%m-%d')<='$this->end_time' AND create_order_sources='".OrderMaster::ORDER_SOURCES_SERVICE."'";
        $groupBy = "DATE_FORMAT(create_time,'%Y-%m-%d')";
        $sql = "SELECT $column FROM yayh_order_master WHERE $where GROUP BY $groupBy";
        $command = $connection->createCommand($sql);
        $result['service'] = $command->queryAll();
        return $result;

    }
}
