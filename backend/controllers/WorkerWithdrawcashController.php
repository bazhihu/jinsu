<?php

namespace backend\controllers;

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
     * Lists all WorkerWithdrawcash models.
     * @return mixed
     */
    public function actionCheck()
    {
        $searchModel = new WorkerWithdrawcashSearch();

        $queryParams = Yii::$app->request->queryParams;

        #限定列表区间为申请审核
        $queryParams['WorkerWithdrawcashSearch']['start'] = 0;
        $queryParams['WorkerWithdrawcashSearch']['end'] = 3;

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
        $queryParams['WorkerWithdrawcashSearch']['start'] = 2;
        $queryParams['WorkerWithdrawcashSearch']['end'] = 3;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkerWithdrawcash model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WorkerWithdrawcash model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WorkerWithdrawcash();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WorkerWithdrawcash model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WorkerWithdrawcash model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
