<?php

namespace backend\controllers;

use Yii;
use backend\models\WorkerCard;
use backend\models\WorkerCardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkerCardController implements the CRUD actions for WorkerCard model.
 */
class WorkerCardController extends Controller
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
     * 护工银行卡号
     * @return string
     */
    public function actionIndex(){
        $searchModel = new WorkerCardSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * 删除银行卡数据
     */
    public function actionDelete(){
        $params = Yii::$app->request->post();
        $id = $params['id'];
        $workerCard = new WorkerCard();
        $return = $workerCard->cardDelete($id);
        echo json_encode($return);
    }

    /**
     * 创建银行卡
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionCreate($id){
        $model = new WorkerCard();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the WorkerCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WorkerCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkerCard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
