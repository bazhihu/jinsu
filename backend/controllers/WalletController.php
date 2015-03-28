<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\WalletWithdrawcash;
use backend\models\WalletUserDetail;
use backend\models\WalletUser;
use backend\models\WalletUserDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WalletUserDetailController implements the CRUD actions for WalletUserDetail model.
 */
class WalletController extends Controller
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
     * 充值记录.
     * @return mixed
     */
    public function actionPayIndex()
    {
        $searchModel = new WalletUserDetailSearch();
        $queryParams = Yii::$app->request->queryParams;

        if(isset($queryParams['WalletUserDetailSearch']['uid']) && $queryParams['WalletUserDetailSearch']['uid']){
            $user = new User();
            $queryParams['WalletUserDetailSearch']['id'] =
                $user->findOne(['username'=>$queryParams['WalletUserDetailSearch']['uid']])->id;
        }
        #指向充值
        $queryParams['WalletUserDetailSearch']['detail_type'] = 2;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 扣款明细
     * @return string
     */
    public function actionDeductionIndex()
    {
        $searchModel = new WalletUserDetailSearch();
        $queryParams = Yii::$app->request->queryParams;

        if(isset($queryParams['WalletUserDetailSearch']['uid']) && $queryParams['WalletUserDetailSearch']['uid']){
            $user = new User();
            $queryParams['WalletUserDetailSearch']['id'] =
                $user->findOne(['username'=>$queryParams['WalletUserDetailSearch']['uid']])->id;
        }
        #指向充值
        $queryParams['WalletUserDetailSearch']['detail_type'] = 1;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('deduction', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WalletUserDetail model.
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
     * 申请提现
     * Creates a new WalletUserDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionApplyCash()
    {
        $uid = Yii::$app->request->get('uid');

        if($uid)
        {
            $user = WalletUser::findOne(['uid'=>$uid]);

            $model = new WalletWithdrawcash(['scenario' => 'pay_create']);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->detail_id]);
            } else {
                return $this->render('applyCash', [
                    'model' => $model,
                    'user'  => $user,
                ]);
            }
        }
    }
    /**
     * 充值
     * @return string|\yii\web\Response
     */
    public function actionPayCreate()
    {
        $uid=Yii::$app->request->get("uid");
        if($uid)
        {
            $model = new WalletUserDetail(['scenario' => 'pay_create']);
            if ($model->load(Yii::$app->request->post()) && $model->recharge($uid)) {
                return $this->redirect(['pay-index', 'uid' => $model->uid]);
            } else {
                $userRow=array();
                $mobile = User::findOne(['id'=>$uid])->username;
                $admin_name = Yii::$app->user->identity->username;

                if($mobile && $admin_name){
                    $userRow = [
                        'uid'=>$uid,
                        'mobile'=>$mobile,  //电话帐号
                        'admin_name'=>$admin_name,  //操作者
                    ];
                }
                return $this->render('pay_create', [
                    'model' => $model,
                    'userRow' => $userRow,
                ]);
            }
        }
    }


    /**
     * Updates an existing WalletUserDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->detail_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WalletUserDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WalletUserDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WalletUserDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WalletUserDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
