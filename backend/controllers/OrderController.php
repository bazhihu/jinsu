<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Order;

use backend\models\OrderPatient;
use backend\models\OrderMaster;
use backend\models\OrderSearch;
use backend\models\WalletUserDetail;
use backend\models\User;
use backend\models\LoginForm;

/**
 * OrderController implements the CRUD actions for OrderMaster model.
 */
class OrderController extends Controller
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
     * Lists all OrderMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        //客服直接登录start
        $uin = empty($_GET['uin'])? 0 : $_GET['uin'];
        if($uin){
            $this->TqLogin($uin);
        }
        //客服直接登录end
        $searchModel = new OrderSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
    /*
         * 客服自动登录
         * $username 客服用户名
         * */
    private function TqLogin($username)
    {
        $model = new LoginForm();
        $LoginForm = array('username'=>$username,'password' => '123456','rememberMe'=>'1' );
        if ($model->load_TQ($LoginForm) && $model->login()) {
            $this->redirect(['/order/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Displays a single OrderMaster model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $orderPatientModel = OrderPatient::findOne(['order_id'=>$id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('view', [
                'model' => $model,
                'orderPatientModel' => $orderPatientModel]);
        }
    }

    /**
     * Creates a new OrderMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderMaster;
        $orderPatientModel = new OrderPatient();
        if ($model->load(Yii::$app->request->post())) {

            $params = Yii::$app->request->post();

            //检查手机号是否注册
            $userModel = new User();
            $user = $userModel->findByMobile($params['OrderMaster']['mobile']);
            if($user && isset($user->id)){
                $params['OrderMaster']['uid'] = $user->id;
            }else{
                //注册手机号
                $userModel->mobile = $params['OrderMaster']['mobile'];
                $userModel->name = $params['OrderMaster']['contact_name'];
                if ($user = $userModel->SystemSignUp()) {
                    $params['OrderMaster']['uid'] = $user->id;
                }
            }
            $params['OrderMaster']['patient_state'] = $params['OrderPatient']['patient_state'];
            $params['OrderMaster']['create_order_sources'] = OrderMaster::ORDER_SOURCES_SERVICE;
            $params['OrderMaster']['customer_service_id'] = \Yii::$app->user->id;

            $order = new Order();
            $order->createOrder($params);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'orderPatientModel' => $orderPatientModel
            ]);
        }
    }

    /**
     * Updates an existing OrderMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $orderPatientModel = OrderPatient::findOne(['order_id'=>$id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'orderPatientModel' => $orderPatientModel
            ]);
        }
    }

    /**
     * 订单支付
     * @param $id
     * @return array
     */
    public function actionPay($id){
        $order = $this->findModel($id);
        $response = $order->pay(WalletUserDetail::PAY_FROM_BACKEND, '后台支付');
        echo Json::encode($response);
    }

    /**
     * 订单确认
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionConfirm($id){
        $order = $this->findModel($id);
        $response = $order->confirm('后台选择护工下单');
        echo Json::encode($response);
    }
    /**
     * 开始服务
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionBegin_service($id){
        $order = $this->findModel($id);
        $response = $order->beginService();
        echo Json::encode($response);
    }

    /**
     * 订单完成
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionFinish($id){
        $order = $this->findModel($id);
        $response = $order->finish();
        echo Json::encode($response);
    }

    /**
     * 订单取消
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionCancel($id){
        $order = $this->findModel($id);
        $response = $order->cancel();
        echo Json::encode($response);
    }

    /**
     * Finds the OrderMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return OrderMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
