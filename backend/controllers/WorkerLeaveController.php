<?php

namespace backend\controllers;

use Yii;
use backend\models\WorkerLeave;
use backend\models\WorkerLeaveSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkerLeaveController implements the CRUD actions for WorkerLeave model.
 */
class WorkerLeaveController extends Controller
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
     * 请假申请
     * @return string|\yii\web\Response
     */
    public function actionCreate($id){
        $model = new WorkerLeave();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }else{
            return $this->render('create', [
                'model' => $model,
                'worker'=>\backend\models\Worker::findOne(['worker_id'=>$id])
            ]);
        }
    }

    /**
     * 请假结束
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionEnd($id){
        $this->layout = "guest.php";
        $params = Yii::$app->getRequest()->getBodyParams();
        $leave = $this->findModel($id);

        if(empty($params['real_end'])){
            return $this->render('end', [
                'model' => $leave
            ]);
        }else{
            $endTime = $params['real_end'];
            $response = $leave->end($endTime);
            echo Json::encode($response);
        }
    }

    /**
     * Finds the WorkerLeave model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WorkerLeave the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkerLeave::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 请假列表
     * @return string
     */
    public function actionIndex(){
        $searchModel = new WorkerLeaveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
