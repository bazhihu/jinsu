<?php

namespace common\models;

use backend\models\WorkerAccount;
use backend\models\WorkerCard;
use backend\models\WorkerIncrement;
use backend\models\WorkerWithdrawcash;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\HttpException;


class WorkerWallet
{
    public $worker_id;//护工ID
    /**
     * 护工提现
     * @return array
     * [
     *      'worker_id' 护工ID
     * ]
     */
    public function withdrawal($params){
        $response = [
            'code'=>'200',
            'msg'=>''
        ];
        $balance = '';//余额
        $worker_id = $params['worker_id'];

        if(!$worker_id){
            $response['code'] = 400;
            return $response;
        }

        $workerAccount = WorkerAccount::findOne(['worker_id'=>$worker_id]);
        if(!$workerAccount){
            $response['code'] = 400;
            return $response;
        }
        $balance = $workerAccount->balance;
        $hospital_id = $workerAccount->hospital_id;

        $workerCard = WorkerCard::findOne(['worker_id'=>$worker_id,'status'=>0]);
        if(!$workerCard){
            $response['code'] = 400;
            return $response;
        }
        $worker_name = $workerCard->worker_name;
        $identity_card = $workerCard->identity_card;
        $bank = $workerCard->bank;
        $bank_card = $workerCard->bank_card;

        $params = array(
            'withdrawcash_no'=>self::generateWorkerNo(),
            'worker_id'=>$worker_id,
            'worker_name'=>$worker_name,
            'money'=>$balance,
            'status'=>0,
            'payee_type'=>0,
            'payee_hospital'=>$hospital_id,
            'payee_id_card'=>$identity_card,
            'payee_bank'=>$bank,
            'payee_bank_card'=>$bank_card,
            'time_apply'=>date("Y-m-d H:i:s"),
            'admin_uid_apply'=>yii::$app->user->identity->getId()?yii::$app->user->identity->getId():'',
        );
        $workerWithdrawcash = new WorkerWithdrawcash();
        $workerWithdrawcash->setAttributes($params,false);
        if(!$workerWithdrawcash->save()){
            $response['code'] = 400;
            return $response;
        }
        $response['msg'] = '申请成功';
        return $response;
    }

    /**
     * 生成护工钱包流水号
     * @return string
     * @throws \Exception
     * @author HZQ
     */
    public static function generateWorkerNo(){
        $workerIncrement = new WorkerIncrement();
        $workerIncrement->insert();
        return date("Ymd").$workerIncrement->id.str_pad(rand(0, 999), 3, 0, STR_PAD_LEFT);
    }
}