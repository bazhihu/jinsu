<?php

namespace backend\controllers;

use backend\models\OrderPatient;
use Yii;
use backend\models\OrderMaster;
use backend\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Order;

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
        return $this->redirect(['view', 'id' => $model->id]);
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

            //检查手机号是否注册@TODO...
            $mobile = $params['OrderMaster']['mobile'];

            $params['OrderMaster']['patient_state'] = $params['OrderPatient']['patient_state'];
            $params['OrderMaster']['create_order_sources'] = OrderMaster::ORDER_SOURCES_SERVICE;

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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
