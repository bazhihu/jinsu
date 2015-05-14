<?php

namespace backend\controllers;

use backend\models\Recharge;
use common\models\Sms;
use common\models\Wallet;
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
                        'actions' => ['recharge', 'ajax-recharge', 'recharge-records', 'debit-records','cash','cash-list','ajax-cash','confirm-list','cash-records','ajax-confirm'],
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
     * 用户充值
     * @param int $uid 用户ID
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRecharge($uid)
    {
        $user = User::findOne(['id'=>$uid]);
        if(empty($user)){
            throw new NotFoundHttpException('用户不存在！');
        }

        $userRow = [
            'uid'       =>$uid,
            'mobile'    =>$user->mobile,  //电话帐号
            'username'  =>$user->username,  //用户名
            'admin_name'=>Yii::$app->user->identity->username,  //操作者
        ];

        $model = new Recharge();
        return $this->render('recharge', [
            'model'   => $model,
            'userRow' => $userRow,
        ]);
    }

    /**
     * 充值ajax
     * @throws \yii\web\HttpException
     */
    public function actionAjaxRecharge(){
        $response = [
            'code'  =>'200',
            'msg'   =>'',
        ];
        if(Yii::$app->request->isAjax){
            $params = Yii::$app->request->post();
            if($params['uid'] && $params['money']){
                $balance = Wallet::recharge($params);
                if($balance){

                    $mobile = User::findOne(['id'=>$params['uid']])->mobile;
                    #发送短信
                    $sms = new Sms();
                    $send = [
                        'mobile'    =>$mobile,
                        'type'      =>Sms::SMS_SUCCESS_RECHARGE,
                        'account'   =>$mobile,
                        'money'     =>$params['money'],
                        'balance'   =>$balance,
                    ];
                    $sms->send($send);

                    $response['msg'] = '成功充值';
                    echo Json::encode($response);
                    exit;
                }
            }
        }
        $response = [
            'code'  =>'400',
            'msg'   =>'充值失败',
        ];
        echo Json::encode($response);
    }
    /**
     * 充值记录.
     * @param $uid
     * @return mixed
     */
    public function actionRechargeRecords($uid=null)
    {
        $searchModel = new WalletUserDetailSearch();
        $queryParams = Yii::$app->request->queryParams;

        if($uid){
            $queryParams['WalletUserDetailSearch']['uid'] = $uid;
        }

        $queryParams['WalletUserDetailSearch']['detail_type'] = '2';

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('rechargeRecords', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 交易明细
     * @return string
     */
    public function actionDebitRecords()
    {
        $searchModel = new WalletUserDetailSearch();
        $queryParams = Yii::$app->request->queryParams;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('debitRecords', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 提现申请
     * @param int $uid 用户ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCash($uid)
    {
        $user = WalletUser::findOne(['uid'=>$uid]);
        if(empty($user)){
            throw new NotFoundHttpException('用户账户余额为零!');
        }
        $model = new WalletWithdrawcash(['scenario' => 'applyCash']);
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['cash-list']);
        } else {
            return $this->render('cash', [
                'model' => $model,
                'user'  => $user,
            ]);
        }
    }

    /**
     * 提现支付列表
     * @return string
     */
    public function actionCashList(){

        $searchModel = new WalletWithdrawcashSearch();
        $queryParams = Yii::$app->request->queryParams;

        #限定列表区间为申请审核
        $queryParams['WalletWithdrawcashSearch']['start'] = 0;
        $queryParams['WalletWithdrawcashSearch']['end'] = 3;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('cashList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * ajax提现操作(同意or拒绝)
     * @return string
     */
    public function actionAjaxCash(){

        if(Yii::$app->request->isAjax && Yii::$app->user->identity->getId())
        {
            $params = Yii::$app->request->post();
            $id     = $params['id'];
            $todo   = $params['todo'];
            $reason   = isset($params['reason'])?$params['reason']:'';
            if($id && isset($todo)) {
                $walletWithdrawcash = new WalletWithdrawcash();
                $cash = [
                    'id'    =>$id,
                    'todo'  =>$todo,
                    'admin_uid'=>Yii::$app->user->identity->getId(),
                ];
                if($reason)
                {
                    $cash['reason'] = $reason;
                }
                $return = $walletWithdrawcash->check($cash);
                if($return['code']==200){
                    return Json::encode($return);
                }
            }
        }
        $response = [
            'code' => '400',
            'msg'  => '请求失败',
        ];
        return Json::encode($response);
    }

    /**
     * 提现支付
     * @return string
     */
    public function actionConfirmList()
    {
        $searchModel = new WalletWithdrawcashSearch();
        $queryParams = Yii::$app->request->queryParams;
        if(isset($queryParams['WalletWithdrawcashSearch']['uid']) && $queryParams['WalletWithdrawcashSearch']['uid']){
            $user = User::findOne(['mobile'=>$queryParams['WalletWithdrawcashSearch']['uid']]);
            $queryParams['WalletWithdrawcashSearch']['id'] = $user?$user->id:"";
        }
        #限定列表区间为申请审核
        $queryParams['WalletWithdrawcashSearch']['start'] = 2;
        $queryParams['WalletWithdrawcashSearch']['end'] = 3;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('confirmList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 提现付款确认操作
     * @param int $id 提现表ID
     * @return string
     */
    public function actionAjaxConfirm($id){
        if(Yii::$app->request->isAjax)
        {
            $response = [
                'code'  =>'200',
                'msg'   =>'',
            ];
            if($id) {
                $walletWithdrawcash = new WalletWithdrawcash();

                if($walletWithdrawcash->pay($id)){
                    $response['msg'] = '操作成功';
                    return Json::encode($response);
                }
            }
        }
        $response = [
            'code  '    =>'400',
            'msg'   =>'账户金额不足',
        ];
        return Json::encode($response);
    }

    /**
     * 提现记录列表
     * @return string
     */
    public function actionCashRecords(){
        $searchModel = new WalletWithdrawcashSearch();
        $queryParams = Yii::$app->request->queryParams;

        #限定列表区间为提现记录
        $queryParams['WalletWithdrawcashSearch']['start'] = 3;
        $queryParams['WalletWithdrawcashSearch']['end'] = 3;

        $dataProvider = $searchModel->search($queryParams);

        return $this->render('cashRecords', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
