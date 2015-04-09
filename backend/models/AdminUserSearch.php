<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AdminUser;

/**
 * AdminUserSearch represents the model behind the search form about `backend\models\AdminUser`.
 */
class AdminUserSearch extends AdminUser
{
    public function rules()
    {
        return [
            [
                [
                    'admin_uid',
                    'phone',
                    'created_at',
                    'updated_at',
                    'status',
                    'modifier_id'
                ],
                'integer'
            ],
            [
                [
                    'username',
                    'auth_key',
                    'hospital_id',
                    'password_hash',
                    'password_reset_token',
                    'staff_id',
                    'staff_name',
                    'staff_role',
                    'created_id',
                ],
                'safe'
            ],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = AdminUser::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $query->orderBy('admin_uid DESC');
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'admin_uid' => $this->admin_uid,
            'hospital_id' => $this->hospital_id,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'created_id' => $this->created_id?$this->findOne(['username'=>$this->created_id])->admin_uid:"",
            'modifier_id' => $this->modifier_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'staff_id', $this->staff_id])
            ->andFilterWhere(['like', 'staff_name', $this->staff_name])
            ->andFilterWhere(['like', 'staff_role', $this->staff_role]);

        return $dataProvider;
    }
}
