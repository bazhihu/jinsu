<?php

namespace backend\controllers;

use backend\models\WorkerAccount;
use backend\models\WorkerCard;
use common\models\WorkerWallet;
use Yii;
use backend\models\WorkerWithdrawcash;
use backend\models\WorkerWithdrawcashSearch;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\VerbFilter;

/**
 * WorkerWithdrawcashController implements the CRUD actions for WorkerWithdrawcash model.
 */
class WorkerWithdrawcashController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Creates a new WorkerWithdrawcash model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $card = WorkerCard::findOne(['worker_id'=>$id,'status'=>0]);

        $balance = WorkerAccount::findOne(['worker_id'=>$id]);

        $model = new WorkerWallet();

        if (Yii::$app->request->post()) {
            $create = $model->withdrawal(Yii::$app->request->post());
            if($create['code'] == 200){
                return $this->redirect(['check']);
            }
        }
        return $this->render('create', [
            'model' => $card,
            'balance'=>$balance,
        ]);
    }

    /**
     * 申请提现
     * @return string
     */
    public function actionIndex(){
        $searchModel = new WorkerWithdrawcashSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all WorkerWithdrawcash models.
     * @return mixed
     */
    public function actionCheck()
    {
        $searchModel = new WorkerWithdrawcashSearch();

        $queryParams = Yii::$app->request->queryParams;

        #限定列表区间为申请审核
        $queryParams['WorkerWithdrawcashSearch']['start'] = '0';
        $queryParams['WorkerWithdrawcashSearch']['end'] = '3';

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('check', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 审核通过
     * @throws HttpException
     */
    public function actionAgree(){
        try {
            $id = Yii::$app->request->post()['id'];
            $cash = $this->findModel($id);
            $return  = $cash->agree();
            echo Json::encode($return);
            exit;
        }catch (Exception $e){
            throw new HttpException(400, print_r($e, true));
        }
    }

    /**
     * Finds the WorkerWithdrawcash model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkerWithdrawcash the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkerWithdrawcash::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException('The requested page does not exist.');
        }
    }

    /**
     * 审核拒绝
     * @throws HttpException
     */
    public function actionRefuse(){
        try {
            $id = Yii::$app->request->post()['id'];
            $cash = $this->findModel($id);
            $return  = $cash->refuse();
            echo Json::encode($return);
            exit;
        }catch (Exception $e){
            throw new HttpException(400, print_r($e, true));
        }
    }

    /**
     * 支付确认页
     * @return string
     */
    public function actionPayment(){
        $searchModel = new WorkerWithdrawcashSearch();

        $queryParams = Yii::$app->request->queryParams;

        #限定列表区间为申请审核
        $queryParams['WorkerWithdrawcashSearch']['start'] = '2';
        $queryParams['WorkerWithdrawcashSearch']['end'] = '3';

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 付款
     */
    public function actionPay(){
        try {
            $id = Yii::$app->request->post()['id'];
            $pay = new WorkerWithdrawcash();
            $return  = $pay->pay($id);
            echo Json::encode($return);
            exit;
        }catch (Exception $e){
            throw new HttpException(400, print_r($e, true));
        }
    }

    /**
     * 提现记录
     * @return string
     */
    public function actionRecord(){
        $searchModel = new WorkerWithdrawcashSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('record', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Finds the WorkerCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkerCard the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findCardModel($id){
        if (($model = WorkerCard::findOne(['worker_id'=>$id,'status'=>'0'])) !== null) {
            return $model;
        } else {
            throw new HttpException('The requested page does not exist.');
        }
    }
}
