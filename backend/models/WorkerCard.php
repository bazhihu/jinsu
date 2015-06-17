<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%worker_card}}".
 *
 * @property string $id
 * @property string $worker_id
 * @property string $worker_name
 * @property string $identity_card
 * @property string $bank
 * @property string $bank_card
 * @property string $add_date
 * @property integer $status
 */
class WorkerCard extends \yii\db\ActiveRecord
{
        public static $_BANK = [
        'ICBC' => '中国工商银行',
        'CBC' => '中国建设银行',
        'ABC' => '中国农业银行',
        'BC' => '中国银行',
        'CMBC' => '招商银行',
        'CNCB' => '中信银行',
    ];//提现工资
public $money;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%worker_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id', 'worker_name', 'identity_card', 'bank', 'bank_card','bank_sub_account', 'add_date'], 'required'],
            [['worker_id', 'status'], 'integer'],
            [['add_date'], 'safe'],
            [['worker_name', 'bank', 'bank_card'], 'string', 'max' => 255],
            [['identity_card'], 'string', 'max' => 18],
            [['bank_sub_account'], 'string', 'max' => 50],
            [['identity_card'],'match','pattern'=>'/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/','message'=>'{attribute}匹配失败！'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'worker_id' => '工号',
            'worker_name' => '姓名',
            'identity_card' => '身份证号码',
            'bank' => '开户行',
            'bank_card' => '银行卡号',
            'bank_sub_account' => '子账户',
            'add_date' => '添加时间',
            'status' => '状态',
        ];
    }

    /**
     * 删除银行卡
     * @param $id
     * @return array
     */
    public function cardDelete($id){
        $response = [
            'code'=>200,
            'msg'=>'',
        ];
        $model = self::findOne($id);
        $model->status = 1;
        if($model->save()){
            return $response;
        }else{
            $response = [
                'code'=>400,
                'msg'=>'操作失败',
            ];
            return $response;
        }
    }

    /**
     * 创建工资卡
     * @return bool
     */
    public function create(){
        $this->add_date = date("Y-m-d H:i:s");
        if(!$this->save()){
            return false;
        }
        return true;
    }
}
