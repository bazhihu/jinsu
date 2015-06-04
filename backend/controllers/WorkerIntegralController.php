<?php

namespace backend\controllers;

use Yii;
use backend\models\WorkerIntegral;
use backend\models\WorkerIntegralSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkerIntegralController implements the CRUD actions for WorkerIntegral model.
 */
class WorkerIntegralController extends Controller
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
     * 积分详情
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id){
        $searchModel = new WorkerIntegralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'id'=>$id
        ]);
    }

    /**
     * Finds the WorkerIntegral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WorkerIntegral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkerIntegral::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
