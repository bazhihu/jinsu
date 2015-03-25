<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Order;

use backend\models\OrderPatient;
use backend\models\OrderMaster;
use backend\models\OrderSearch;

use amnah\yii2\user\models\User;

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
        $searchModel = new OrderSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single OrderMaster model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('view', ['model' => $model]);
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
                $userModel->setScenario('register'); //设置为注册场景
                $userModel->mobile = $params['OrderMaster']['mobile'];
                $userModel->username = $params['OrderMaster']['contact_name'];

                if ($user = $userModel->SystemSignUp()) {
                    $params['OrderMaster']['uid'] = $user->id;
                }
            }
            $params['OrderMaster']['patient_state'] = $params['OrderPatient']['patient_state'];
            $params['OrderMaster']['create_order_sources'] = OrderMaster::ORDER_SOURCES_SERVICE;

            //判断是否挑选护工


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
     * Deletes an existing OrderMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();
        if (Yii::$app->getRequest()->isAjax) {
            $dataProvider = new ActiveDataProvider([
                'query' => OrderMaster::find(),
                'sort' => false
            ]);
            return $this->renderPartial('index', [
                'dataProvider' => $dataProvider
            ]);
        }
        return $this->redirect(['index']);
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
