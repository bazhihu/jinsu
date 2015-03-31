<?php

namespace backend\controllers;

use Yii;
use backend\models\WalletWithdrawcashSearch;
use backend\models\User;
use backend\models\WalletWithdrawcash;
use backend\models\WalletUserDetail;
use backend\models\WalletUser;
use backend\models\WalletUserDetailSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * WalletUserDetailController implements the CRUD actions for WalletUserDetail model.
 */
class WalletController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['pay-index', 'deduction-index', 'apply-cash', 'apply-list','apply','to-pay','pay','payment','pay-create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
                $user->findOne(['mobile'=>$queryParams['WalletUserDetailSearch']['uid']])->id;
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
                $user->findOne(['mobile'=>$queryParams['WalletUserDetailSearch']['uid']])->id;
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

            $model = new WalletWithdrawcash(['scenario' => 'applyCash']);
            if ($model->load(Yii::$app->request->post()) && $model->create()) {
                return $this->redirect(['applyList']);
            } else {
                return $this->render('applyCash', [
                    'model' => $model,
                    'user'  => $user,
                ]);
            }
        }
    }

    /**
     * 提现申请页
     * @return string
     */
    public function actionApplyList(){

        $searchModel = new WalletWithdrawcashSearch();
        $queryParams = Yii::$app->request->queryParams;

        if(isset($queryParams['WalletWithdrawcashSearch']['uid']) && $queryParams['WalletWithdrawcashSearch']['uid']){
            $user = new User();
            $queryParams['WalletWithdrawcashSearch']['id'] =
                $user->findOne(['mobile'=>$queryParams['WalletWithdrawcashSearch']['uid']])->id;
        }
        #限定列表区间为申请审核
        $queryParams['WalletWithdrawcashSearch']['start'] = 0;
        $queryParams['WalletWithdrawcashSearch']['end'] = 2;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('applyList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 审核申请退款ajax
     * @return string
     */
    public function actionApply(){

        if(Yii::$app->request->isAjax && Yii::$app->user->identity->getId())
        {
            $response = [
                'code'      =>'200',
                'msg'   =>'',
            ];
            $id     = Yii::$app->request->post()['id'];
            $todo   = Yii::$app->request->post()['todo'];
            if($id && isset($todo)) {
                $walletWithdrawcash = new WalletWithdrawcash();
                $params = [
                    'id'    =>$id,
                    'todo'  =>$todo,
                    'admin_uid'=>Yii::$app->user->identity->getId(),
                ];
                if($walletWithdrawcash->check($params)){
                    $response['msg'] = '操作成功';
                    return Json::encode($response);
                }
            }
        }
        $response = [
            'code  '    =>'400',
            'msg'   =>'请求失败',
        ];
        return Json::encode($response);
    }

    /**
     * 提现支付
     * @return string
     */
    public function actionToPay()
    {
        $searchModel = new WalletWithdrawcashSearch();
        $queryParams = Yii::$app->request->queryParams;
        if(isset($queryParams['WalletWithdrawcashSearch']['uid']) && $queryParams['WalletWithdrawcashSearch']['uid']){
            $user = new User();
            $queryParams['WalletWithdrawcashSearch']['id'] =
                $user->findOne(['mobile'=>$queryParams['WalletWithdrawcashSearch']['uid']])->id;
        }
        #限定列表区间为申请审核
        $queryParams['WalletWithdrawcashSearch']['start'] = 2;
        $queryParams['WalletWithdrawcashSearch']['end'] = 3;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('topay', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 付款操作
     * @return string
     */
    public function actionPay(){
        if(Yii::$app->request->isAjax)
        {
            $response = [
                'code'  =>'200',
                'msg'   =>'',
            ];
            $id     = Yii::$app->request->post()['id'];
            if($id) {
                $walletWithdrawcash = new WalletWithdrawcash();
                $params = [
                    'id'        =>$id,
                    'admin_uid' =>Yii::$app->user->identity->getId(),
                ];
                if($walletWithdrawcash->pay($params)){
                    $response['msg'] = '操作成功';
                    return Json::encode($response);
                }
            }
        }
        $response = [
            'code  '    =>'400',
            'msg'   =>'请求失败',
        ];
        return Json::encode($response);
    }

    /**
     * 付款记录
     * @return string
     */
    public function actionPayment(){
        $searchModel = new WalletWithdrawcashSearch();
        $queryParams = Yii::$app->request->queryParams;

        if(isset($queryParams['WalletWithdrawcashSearch']['uid']) && $queryParams['WalletWithdrawcashSearch']['uid']){
            $user = new User();
            $queryParams['WalletWithdrawcashSearch']['id'] =
                $user->findOne(['mobile'=>$queryParams['WalletWithdrawcashSearch']['uid']])->id;
        }
        #限定列表区间为提现记录
        $queryParams['WalletWithdrawcashSearch']['start'] = 3;
        $queryParams['WalletWithdrawcashSearch']['end'] = 3;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
            if ($model->load(Yii::$app->request->post()) && $model->recharge()) {
                return $this->redirect(['pay-index', 'uid' => $model->uid]);
            } else {
                $userRow=array();
                $mobile = User::findOne(['id'=>$uid])->mobile;
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
