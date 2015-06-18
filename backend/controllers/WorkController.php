<?php

namespace backend\controllers;
use backend\models\OrderMaster;
use Yii;
use backend\models\Work;
use backend\models\WorkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\WorkIncrement;

/**
 * WorkController implements the CRUD actions for Work model.
 */
class WorkController extends Controller
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
     * Lists all Work models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Work model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id,$create=0)
    {
        $model = $this->findModel($id);
        $orderInfo = OrderMaster::findOne($model['order_id']);
        if ($model->load(Yii::$app->request->post())) {
            $model['solve_date'] = date('Y-m-d H:i:s');
            $model['solver'] = yii::$app->user->getId();
            $model['status'] = 2;
            if ($model->save()) {
                return $this->render('view', [
                    'model' => $model,
                    'orderInfo' => $orderInfo,
                    'create'=>0
                ]);

            }
        }else{
            return $this->render('view', [
                'model' => $model,
                'orderInfo'=>$orderInfo,
                'create'=>$create
            ]);
        }
    }


    /**
     * Creates a new Work model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($order_id=0)
    {
        $model = new Work();
        $orderInfo = OrderMaster::findOne($order_id);
        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post()['Work'];
            $params['work_no'] = $this->generateWorkNo();
            $params['order_id'] = $orderInfo['order_id'];
            $params['order_no'] = $orderInfo['order_no'];
            $params['worker_id'] = $orderInfo['worker_no'];
            $params['worker_name'] =  $orderInfo['worker_name'];
            $params['from_where'] =  '400';
            $params['add_date'] = date('Y-m-d H:i:s');
            $params['adder'] = yii::$app->user->getId();
            $params['status'] =  1;
            $model->attributes = $params;
            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->work_id]);
            }else{
                return $this->render('create', ['model' => $model,'orderInfo'=>$orderInfo]);
            }
        }else{
            return $this->render('create', ['model' => $model,'orderInfo'=>$orderInfo]);
        }
    }

    /**
     * Updates an existing Work model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->work_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Work model.
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
     * Finds the Work model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Work the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Work::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 生成工单号
     * @return string
     * @throws \Exception
     * @author tiancq
     */
    protected function generateWorkNo(){
        $workIncrement = new WorkIncrement();
        $workIncrement->insert();
        return date("Ymd").$workIncrement->id.str_pad(rand(0, 999), 3, 0, STR_PAD_LEFT);
    }
}
